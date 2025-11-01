<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_transaction_id = intval($_POST['appointment_transaction_id'] ?? 0);
    $dentist_id = intval($_POST['dentist_id'] ?? 0);
    $promo_id = !empty($_POST['promo_id']) ? intval($_POST['promo_id']) : null;
    $notes = trim($_POST['notes'] ?? '');
    $admin_user_id = intval($_SESSION['user_id'] ?? 0);
    $services = $_POST['appointmentServices'] ?? [];
    $quantities = $_POST['serviceQuantity'] ?? [];
    $total_payment = floatval($_POST['total_payment'] ?? 0);
    $payment_method = $_POST['payment_method'] ?? null;
    
    $fitness_status = trim($_POST['fitness_status'] ?? '');
    $diagnosis = trim($_POST['diagnosis'] ?? '');
    $remarks = trim($_POST['remarks'] ?? '');

    try {
        $conn->begin_transaction();

        $stmt = $conn->prepare("
            INSERT INTO dental_transaction (
                appointment_transaction_id, dentist_id, promo_id, payment_method, total, notes,
                admin_user_id, fitness_status, diagnosis, remarks, date_created, date_updated
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        $stmt->bind_param(
            "iiisdsisss",
            $appointment_transaction_id,
            $dentist_id,
            $promo_id,
            $payment_method,
            $total_payment,
            $notes,
            $admin_user_id,
            $fitness_status,
            $diagnosis,
            $remarks
        );
        $stmt->execute();

        $dental_transaction_id = $stmt->insert_id;
        $stmt->close();

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

        if (strtolower($payment_method) === 'cashless' && isset($_FILES['receipt_upload']) && $_FILES['receipt_upload']['error'] === UPLOAD_ERR_OK) {
            $getPatient = $conn->prepare("
                SELECT u.last_name 
                FROM appointment_transaction at
                JOIN users u ON u.user_id = at.user_id
                WHERE at.appointment_transaction_id = ?
            ");
            $getPatient->bind_param("i", $appointment_transaction_id);
            $getPatient->execute();
            $result = $getPatient->get_result();
            $patient = $result->fetch_assoc();
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

            $oldFiles = glob($uploadDir . $dental_transaction_id . "_*.*");
            foreach ($oldFiles as $oldFile) {
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
        $_SESSION['updateSuccess'] = "Transaction added successfully!";
    } catch (Exception $e) {
        $conn->rollback();
        error_log("INSERT TRANSACTION ERROR: " . $e->getMessage());
        $_SESSION['updateError'] = "Failed to add transaction.";
    }

    header("Location: " . BASE_URL . "/Admin/pages/manage_appointment.php?id=" . $appointment_transaction_id . "&backTab=recent&tab=transaction");
    exit();
}
?>
