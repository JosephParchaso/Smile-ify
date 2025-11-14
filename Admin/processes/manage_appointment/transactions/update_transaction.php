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
    $additional_payment = floatval($_POST['additional_payment'] ?? 0);
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
        if (!$stmtCheck) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmtCheck->bind_param("ii", $dental_transaction_id, $appointment_transaction_id);
        if (!$stmtCheck->execute()) {
            throw new Exception("Execute failed: " . $stmtCheck->error);
        }

        if (method_exists($stmtCheck, 'get_result')) {
            $result = $stmtCheck->get_result();
            if ($result === false) {
                throw new Exception("get_result() failed. Possibly mysqlnd not enabled.");
            }
            $existing = $result->fetch_assoc();
        } else {
            $stmtCheck->bind_result($dentist_id_old, $promo_id_old, $payment_method_old, $total_old, $additional_old, $notes_old, $fitness_old, $diagnosis_old, $remarks_old);
            if ($stmtCheck->fetch()) {
                $existing = [
                    'dentist_id' => $dentist_id_old,
                    'promo_id' => $promo_id_old,
                    'payment_method' => $payment_method_old,
                    'total' => $total_old,
                    'additional_payment' => $additional_old,
                    'notes' => $notes_old,
                    'fitness_status' => $fitness_old,
                    'diagnosis' => $diagnosis_old,
                    'remarks' => $remarks_old
                ];
            } else {
                $existing = null;
            }
        }
        $stmtCheck->close();

        if (!$existing) {
            $_SESSION['updateError'] = "Transaction not found.";
            header("Location: " . BASE_URL . "/Admin/pages/manage_appointment.php?id=" . $appointment_transaction_id);
            exit();
        }

        $hasChanges = (
            $existing['dentist_id'] != $dentist_id ||
            $existing['promo_id'] != $promo_id ||
            $existing['payment_method'] !== $payment_method ||
            $existing['total'] != $total_payment ||
            $existing['additional_payment'] != $additional_payment ||
            trim($existing['notes']) !== $notes ||
            trim($existing['fitness_status']) !== $fitness_status ||
            trim($existing['diagnosis']) !== $diagnosis ||
            trim($existing['remarks']) !== $remarks
        );

        $conn->begin_transaction();

        if ($hasChanges) {
            $promo_name_snapshot = null;
            $promo_type_snapshot = null;
            $promo_value_snapshot = null;

            if (!empty($promo_id)) {
                $stmtPromo = $conn->prepare("SELECT name, discount_type, discount_value FROM promo WHERE promo_id = ?");
                $stmtPromo->bind_param("i", $promo_id);
                $stmtPromo->execute();
                $promo = $stmtPromo->get_result()->fetch_assoc();
                $stmtPromo->close();

                if ($promo) {
                    $promo_name_snapshot = $promo['name'];
                    $promo_type_snapshot = $promo['discount_type'];
                    $promo_value_snapshot = $promo['discount_value'];
                }
            }

            $stmt = $conn->prepare("
                UPDATE dental_transaction 
                SET 
                    dentist_id = ?, 
                    promo_id = ?, 
                    payment_method = ?, 
                    total = ?, 
                    additional_payment = ?, 
                    notes = ?, 
                    fitness_status = ?,
                    diagnosis = ?,
                    remarks = ?,
                    admin_user_id = ?, 
                    date_updated = NOW(),
                    promo_name = ?, 
                    promo_type = ?, 
                    promo_value = ?
                WHERE dental_transaction_id = ? 
                    AND appointment_transaction_id = ?
            ");
            $stmt->bind_param(
                "iisddssssisssii",
                $dentist_id,
                $promo_id,
                $payment_method,
                $total_payment,
                $additional_payment,
                $notes,
                $fitness_status,
                $diagnosis,
                $remarks,
                $admin_user_id,
                $promo_name_snapshot,
                $promo_type_snapshot,
                $promo_value_snapshot,
                $dental_transaction_id,
                $appointment_transaction_id
            );
            $stmt->execute();
            $stmt->close();
            
            if (strtolower($payment_method) === 'cash') {
                $getReceipt = $conn->prepare("SELECT cashless_receipt FROM dental_transaction WHERE dental_transaction_id = ?");
                $getReceipt->bind_param("i", $dental_transaction_id);
                $getReceipt->execute();
                $resultReceipt = $getReceipt->get_result()->fetch_assoc();
                $getReceipt->close();

                if (!empty($resultReceipt['cashless_receipt'])) {
                    $oldPath = $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify' . $resultReceipt['cashless_receipt'];
                    if (is_file($oldPath)) {
                        unlink($oldPath);
                    }

                    $stmtClear = $conn->prepare("
                        UPDATE dental_transaction
                        SET cashless_receipt = NULL, date_updated = NOW()
                        WHERE dental_transaction_id = ?
                    ");
                    $stmtClear->bind_param("i", $dental_transaction_id);
                    $stmtClear->execute();
                    $stmtClear->close();
                }
            }

            $conn->query("DELETE FROM dental_transaction_services WHERE dental_transaction_id = " . intval($dental_transaction_id));

            if (!empty($services)) {
                $serviceIdsStr = implode(',', array_map('intval', $services));
                $serviceQuery = $conn->query("SELECT service_id, name, price FROM service WHERE service_id IN ($serviceIdsStr)");

                $serviceMap = [];
                while ($row = $serviceQuery->fetch_assoc()) {
                    $serviceMap[$row['service_id']] = [
                        'name' => $row['name'],
                        'price' => $row['price']
                    ];
                }

                $stmtService = $conn->prepare("
                    INSERT INTO dental_transaction_services 
                    (dental_transaction_id, service_id, service_name, service_price, quantity)
                    VALUES (?, ?, ?, ?, ?)
                ");

                foreach ($services as $service_id) {
                    $quantity = isset($quantities[$service_id]) ? intval($quantities[$service_id]) : 1;
                    $service_name = $serviceMap[$service_id]['name'] ?? '';
                    $service_price = $serviceMap[$service_id]['price'] ?? 0;

                    $stmtService->bind_param("iisdi", $dental_transaction_id, $service_id, $service_name, $service_price, $quantity);
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
