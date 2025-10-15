<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentId = $_POST['appointment_id'] ?? null;
    $action = $_POST['status'] ?? null;
    $userId = $_POST['user_id'] ?? null;
    $branchId = $_SESSION['branch_id'] ?? null;

    if (!$appointmentId || !$userId || $action !== 'complete' || !$branchId) {
        $_SESSION['updateError'] = "Invalid request. Missing or incorrect fields.";
        header("Location: " . BASE_URL . "/Admin/pages/patients.php");
        exit;
    }

    try {
        $conn->begin_transaction();

        $check = $conn->prepare("
            SELECT appointment_date, appointment_time, status, user_id 
            FROM appointment_transaction 
            WHERE appointment_transaction_id = ?
        ");
        $check->bind_param("i", $appointmentId);
        $check->execute();
        $result = $check->get_result();
        if ($result->num_rows === 0) throw new Exception("Appointment not found.");
        $row = $result->fetch_assoc();
        $check->close();

        if (strtolower($row['status']) === 'completed') {
            throw new Exception("This appointment has already been marked as completed.");
        }

        $txQuery = $conn->prepare("
            SELECT dental_transaction_id 
            FROM dental_transaction 
            WHERE appointment_transaction_id = ?
        ");
        $txQuery->bind_param("i", $appointmentId);
        $txQuery->execute();
        $txResult = $txQuery->get_result();
        if ($txResult->num_rows === 0) throw new Exception("No dental transaction found. Please record transaction before completing.");
        $txRow = $txResult->fetch_assoc();
        $dentalTransactionId = $txRow['dental_transaction_id'];
        $txQuery->close();

        $vitalQuery = $conn->prepare("
            SELECT vitals_id 
            FROM dental_vital 
            WHERE appointment_transaction_id = ?
        ");
        $vitalQuery->bind_param("i", $appointmentId);
        $vitalQuery->execute();
        $vitalResult = $vitalQuery->get_result();
        if ($vitalResult->num_rows === 0) throw new Exception("No vital record found. Please record vitals before completing.");
        $vitalQuery->close();

        $srvQuery = $conn->prepare("
            SELECT COUNT(*) as service_count
            FROM dental_transaction_services
            WHERE dental_transaction_id = ?
        ");
        $srvQuery->bind_param("i", $dentalTransactionId);
        $srvQuery->execute();
        $srvResult = $srvQuery->get_result();
        $srvRow = $srvResult->fetch_assoc();
        $srvCount = $srvRow['service_count'] ?? 0;
        $srvQuery->close();
        if ($srvCount === 0) throw new Exception("No services found for this transaction. Please add services before completing.");

        $lowSupplies = [];
        $srvQuery = $conn->prepare("
            SELECT service_id FROM dental_transaction_services
            WHERE dental_transaction_id = ?
        ");
        $srvQuery->bind_param("i", $dentalTransactionId);
        $srvQuery->execute();
        $srvResult = $srvQuery->get_result();

        while ($srv = $srvResult->fetch_assoc()) {
            $serviceId = $srv['service_id'];
            $supplyQuery = $conn->prepare("
                SELECT supply_id, quantity_used 
                FROM service_supplies 
                WHERE service_id = ?
            ");
            $supplyQuery->bind_param("i", $serviceId);
            $supplyQuery->execute();
            $supplyResult = $supplyQuery->get_result();

            while ($sup = $supplyResult->fetch_assoc()) {
                $supplyId = $sup['supply_id'];
                $qtyUsed = $sup['quantity_used'];

                $checkQty = $conn->prepare("
                    SELECT quantity, reorder_level 
                    FROM branch_supply 
                    WHERE branch_id = ? AND supply_id = ?
                ");
                $checkQty->bind_param("ii", $branchId, $supplyId);
                $checkQty->execute();
                $checkRes = $checkQty->get_result();

                if ($checkRes->num_rows === 0) {
                    $lowSupplies[] = "Supply ID $supplyId not found in branch supply.";
                    $checkQty->close();
                    continue;
                }

                $supplyRow = $checkRes->fetch_assoc();
                $currentQty = (float)$supplyRow['quantity'];
                $reorderLevel = (float)$supplyRow['reorder_level'];
                $checkQty->close();

                if ($currentQty < $qtyUsed) {
                    $lowSupplies[] = "Supply ID $supplyId insufficient (available: $currentQty, required: $qtyUsed)";
                } elseif (($currentQty - $qtyUsed) <= $reorderLevel) {
                    $lowSupplies[] = "Supply ID $supplyId is below reorder level (remaining: " . ($currentQty - $qtyUsed) . ")";
                }
            }
            $supplyQuery->close();
        }
        $srvQuery->close();

        if (!empty($lowSupplies)) {
            $adminMsg = "Appointment ID #$appointmentId cannot be completed due to supply issues:\n";
            foreach ($lowSupplies as $msg) $adminMsg .= "- $msg\n";

            $adminQuery = $conn->query("SELECT user_id FROM users WHERE role = 'admin'");
            while ($admin = $adminQuery->fetch_assoc()) {
                $adminId = $admin['user_id'];
                $notif_stmt = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
                $notif_stmt->bind_param("is", $adminId, $adminMsg);
                $notif_stmt->execute();
                $notif_stmt->close();
            }
            $adminQuery->close();

            throw new Exception("Cannot complete appointment due to insufficient or low supply stock.");
        }

        $srvQuery = $conn->prepare("
            SELECT service_id FROM dental_transaction_services
            WHERE dental_transaction_id = ?
        ");
        $srvQuery->bind_param("i", $dentalTransactionId);
        $srvQuery->execute();
        $srvResult = $srvQuery->get_result();

        while ($srv = $srvResult->fetch_assoc()) {
            $serviceId = $srv['service_id'];
            $supplyQuery = $conn->prepare("
                SELECT supply_id, quantity_used 
                FROM service_supplies 
                WHERE service_id = ?
            ");
            $supplyQuery->bind_param("i", $serviceId);
            $supplyQuery->execute();
            $supplyResult = $supplyQuery->get_result();

            while ($sup = $supplyResult->fetch_assoc()) {
                $supplyId = $sup['supply_id'];
                $qtyUsed = $sup['quantity_used'];

                $updateSupply = $conn->prepare("
                    UPDATE branch_supply 
                    SET quantity = quantity - ?, date_updated = NOW()
                    WHERE branch_id = ? AND supply_id = ?
                ");
                $updateSupply->bind_param("dii", $qtyUsed, $branchId, $supplyId);
                if (!$updateSupply->execute()) throw new Exception("Failed to update supply for supply_id: $supplyId");
                $updateSupply->close();
            }
            $supplyQuery->close();
        }
        $srvQuery->close();

        $stmt = $conn->prepare("
            UPDATE appointment_transaction
            SET status = 'Completed', date_updated = NOW()
            WHERE appointment_transaction_id = ?
        ");
        $stmt->bind_param("i", $appointmentId);
        if (!$stmt->execute()) throw new Exception("Failed to update appointment: " . $stmt->error);
        $stmt->close();

        $formattedDate = date("F j, Y", strtotime($row['appointment_date']));
        $formattedTime = date("g:i A", strtotime($row['appointment_time']));
        $message = "Your appointment ($formattedDate at $formattedTime) has been marked as completed. Thank you for visiting!";
        $patientId = $row['user_id'];
        $notif_stmt = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
        $notif_stmt->bind_param("is", $patientId, $message);
        $notif_stmt->execute();
        $notif_stmt->close();

        $conn->commit();

        $_SESSION['updateSuccess'] = "Appointment completed successfully. Supplies updated.";
        header("Location: " . BASE_URL . "/Admin/pages/patients.php");
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['updateError'] = "Error: " . $e->getMessage();
        header("Location: " . BASE_URL . "/Admin/pages/patients.php");
        exit;
    }
} else {
    header("Location: " . BASE_URL . "/index.php");
    exit;
}

$conn->close();
?>
