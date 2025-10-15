<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dental_transaction_id = intval($_POST['dental_transaction_id'] ?? 0);
    $appointment_transaction_id = intval($_POST['appointment_transaction_id'] ?? 0);
    $dentist_id = intval($_POST['dentist_id'] ?? 0);
    $promo_id = !empty($_POST['promo_id']) ? intval($_POST['promo_id']) : null;
    $notes = trim($_POST['notes'] ?? '');
    $total_payment = floatval($_POST['total_payment'] ?? 0);
    $admin_user_id = intval($_SESSION['user_id'] ?? 0);
    $services = $_POST['appointmentServices'] ?? [];
    $quantities = $_POST['serviceQuantity'] ?? [];

    try {
        $stmtCheck = $conn->prepare("
            SELECT dentist_id, promo_id, total, notes 
            FROM dental_transaction 
            WHERE dental_transaction_id = ? AND appointment_transaction_id = ?
        ");
        $stmtCheck->bind_param("ii", $dental_transaction_id, $appointment_transaction_id);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();
        $existing = $result->fetch_assoc();
        $stmtCheck->close();

        $hasChanges = (
            $existing['dentist_id'] != $dentist_id ||
            $existing['promo_id'] != $promo_id ||
            $existing['total'] != $total_payment ||
            trim($existing['notes']) !== $notes
        );

        if ($hasChanges) {
            $conn->begin_transaction();

            $stmt = $conn->prepare("
                UPDATE dental_transaction 
                SET 
                    dentist_id = ?, 
                    promo_id = ?, 
                    total = ?, 
                    notes = ?, 
                    admin_user_id = ?, 
                    date_updated = NOW()
                WHERE dental_transaction_id = ? 
                AND appointment_transaction_id = ?
            ");
            $stmt->bind_param(
                "iiisiii",
                $dentist_id,
                $promo_id,
                $total_payment,
                $notes,
                $admin_user_id,
                $dental_transaction_id,
                $appointment_transaction_id
            );
            $stmt->execute();
            $stmt->close();

            $conn->query("DELETE FROM dental_transaction_services WHERE dental_transaction_id = " . $dental_transaction_id);

            if (!empty($services)) {
                $stmtService = $conn->prepare("
                    INSERT INTO dental_transaction_services (dental_transaction_id, service_id, quantity)
                    VALUES (?, ?, ?)
                ");
                foreach ($services as $service_id) {
                    $quantity = isset($quantities[$service_id]) ? intval($quantities[$service_id]) : 1;
                    $stmtService->bind_param("iii", $dental_transaction_id, $service_id, $quantity);
                    $stmtService->execute();
                }
                $stmtService->close();
            }

            $conn->commit();
            $_SESSION['updateSuccess'] = "Transaction updated successfully!";
        } else {
            $_SESSION['updateInfo'] = "No changes made.";
        }
    } catch (Exception $e) {
        if ($conn->in_transaction()) $conn->rollback();
        error_log("UPDATE TRANSACTION ERROR: " . $e->getMessage());
        $_SESSION['updateError'] = "Failed to update transaction.";
    }

    header("Location: " . BASE_URL . "/Admin/pages/manage_appointment.php?id=" . $appointment_transaction_id . "&backTab=recent&tab=transaction");
    exit();
}
?>
