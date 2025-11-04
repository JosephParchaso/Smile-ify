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
    $payment_method = $_POST['payment_method'] ?? null;
    $notes = trim($_POST['notes'] ?? '');
    $total_payment = floatval($_POST['total_payment'] ?? 0);
    $admin_user_id = intval($_SESSION['user_id'] ?? 0);
    $services = $_POST['appointmentServices'] ?? [];
    $quantities = $_POST['serviceQuantity'] ?? [];

    $fitness_status = trim($_POST['fitness_status'] ?? '');
    $diagnosis = trim($_POST['diagnosis'] ?? '');
    $remarks = trim($_POST['remarks'] ?? '');

    try {
        $stmtCheck = $conn->prepare("
            SELECT dentist_id, promo_id, payment_method, total, notes,
                    fitness_status, diagnosis, remarks
            FROM dental_transaction 
            WHERE dental_transaction_id = ? AND appointment_transaction_id = ?
        ");
        $stmtCheck->bind_param("ii", $dental_transaction_id, $appointment_transaction_id);
        $stmtCheck->execute();
        $existing = $stmtCheck->get_result()->fetch_assoc();
        $stmtCheck->close();

        $hasChanges = (
            $existing['dentist_id'] != $dentist_id ||
            $existing['promo_id'] != $promo_id ||
            $existing['payment_method'] !== $payment_method ||
            $existing['total'] != $total_payment ||
            trim($existing['notes']) !== $notes ||
            trim($existing['fitness_status']) !== $fitness_status ||
            trim($existing['diagnosis']) !== $diagnosis ||
            trim($existing['remarks']) !== $remarks
        );

        $conn->begin_transaction();

        if ($hasChanges) {
            $serviceNames = [];
            $servicePrices = [];

            if (!empty($services)) {
                $serviceIdsStr = implode(',', array_map('intval', $services));
                $resultServices = $conn->query("SELECT service_id, service_name, price FROM service WHERE service_id IN ($serviceIdsStr)");

                while ($row = $resultServices->fetch_assoc()) {
                    $sid = $row['service_id'];
                    $serviceNames[] = $row['service_name'];
                    $servicePrices[] = number_format($row['price'], 2, '.', '');
                }
            }

            $service_name_snapshot = implode(', ', $serviceNames);
            $service_price_snapshot = implode(', ', $servicePrices);

            $promo_name_snapshot = null;
            $promo_type_snapshot = null;
            $promo_value_snapshot = null;

            if (!empty($promo_id)) {
                $stmtPromo = $conn->prepare("SELECT promo_name, promo_type, promo_value FROM promo WHERE promo_id = ?");
                $stmtPromo->bind_param("i", $promo_id);
                $stmtPromo->execute();
                $promo = $stmtPromo->get_result()->fetch_assoc();
                $stmtPromo->close();

                if ($promo) {
                    $promo_name_snapshot = $promo['promo_name'];
                    $promo_type_snapshot = $promo['promo_type'];
                    $promo_value_snapshot = $promo['promo_value'];
                }
            }

            $stmt = $conn->prepare("
                UPDATE dental_transaction 
                SET 
                    dentist_id = ?, 
                    promo_id = ?, 
                    payment_method = ?, 
                    total = ?, 
                    notes = ?, 
                    fitness_status = ?,
                    diagnosis = ?,
                    remarks = ?,
                    admin_user_id = ?, 
                    date_updated = NOW(),
                    service_name = ?, 
                    service_price = ?, 
                    promo_name = ?, 
                    promo_type = ?, 
                    promo_value = ?
                WHERE dental_transaction_id = ? 
                    AND appointment_transaction_id = ?
            ");

            $stmt->bind_param(
                "iisdssssisssssii",
                $dentist_id,
                $promo_id,
                $payment_method,
                $total_payment,
                $notes,
                $fitness_status,
                $diagnosis,
                $remarks,
                $admin_user_id,
                $service_name_snapshot,
                $service_price_snapshot,
                $promo_name_snapshot,
                $promo_type_snapshot,
                $promo_value_snapshot,
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
        }

        if (strtolower($payment_method) === 'cashless' && isset($_FILES['receipt_upload']) && $_FILES['receipt_upload']['error'] === UPLOAD_ERR_OK) {
            $getPatient = $conn->prepare("
                SELECT u.last_name 
                FROM appointment_transaction at
                JOIN users u ON u.user_id = at.user_id
                WHERE at.appointment_transaction_id = ?
            ");
            $getPatient->bind_param("i", $appointment_transaction_id);
            $getPatient->execute();
            $patient = $getPatient->get_result()->fetch_assoc();
            $getPatient->close();

            $last_name_clean = $patient ? preg_replace('/[^a-zA-Z0-9_-]/', '', strtolower($patient['last_name'])) : 'unknown';

            $fileTmpPath = $_FILES['receipt_upload']['tmp_name'];
            $fileExt = strtolower(pathinfo($_FILES['receipt_upload']['name'], PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($fileExt, $allowedTypes)) {
                $_SESSION['updateError'] = "Invalid file type. Allowed: JPG, PNG, WEBP.";
                header("Location: " . BASE_URL . "/Admin/pages/manage_appointment.php?id=" . $appointment_transaction_id . "&backTab=recent&tab=transaction");
                exit();
            }

            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/images/payments/cashless_payments/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $fileName = $dental_transaction_id . "_" . $last_name_clean . "." . $fileExt;
            $targetPath = $uploadDir . $fileName;

            foreach (glob($uploadDir . $dental_transaction_id . "_*.*") as $oldFile) {
                if (is_file($oldFile)) unlink($oldFile);
            }

            if (!move_uploaded_file($fileTmpPath, $targetPath)) {
                $_SESSION['updateError'] = "Failed to upload receipt file.";
                header("Location: " . BASE_URL . "/Admin/pages/manage_appointment.php?id=" . $appointment_transaction_id . "&backTab=recent&tab=transaction");
                exit();
            }

            $receiptPath = "/images/payments/cashless_payments/" . $fileName;
            $updateReceipt = $conn->prepare("
                UPDATE dental_transaction 
                SET cashless_receipt = ?, date_updated = NOW()
                WHERE dental_transaction_id = ?
            ");
            $updateReceipt->bind_param("si", $receiptPath, $dental_transaction_id);
            $updateReceipt->execute();
            $updateReceipt->close();
        }

        $conn->commit();
        if ($hasChanges || (isset($_FILES['receipt_upload']) && $_FILES['receipt_upload']['error'] === UPLOAD_ERR_OK)) {
            $_SESSION['updateSuccess'] = "Transaction updated successfully!";
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
