<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_transaction_id = intval($_POST['appointment_transaction_id']);
    $dentist_id = intval($_POST['dentist_id']);
    $promo_id = !empty($_POST['promo_id']) ? intval($_POST['promo_id']) : null;
    $notes = trim($_POST['notes'] ?? '');
    $admin_user_id = intval($_POST['admin_user_id']);
    $services = $_POST['appointmentServices'] ?? [];
    $quantities = $_POST['serviceQuantity'] ?? [];
    $total_payment = floatval($_POST['total_payment'] ?? 0);

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("
            INSERT INTO dental_transaction (
                appointment_transaction_id, dentist_id, promo_id, total, notes, admin_user_id, date_created
            ) VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param(
            "iiidsi",
            $appointment_transaction_id,
            $dentist_id,
            $promo_id,
            $total_payment,
            $notes,
            $admin_user_id
        );
        $stmt->execute();

        $dental_transaction_id = $stmt->insert_id;
        $stmt->close();

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

        $conn->commit();

        $_SESSION['updateSuccess'] = "Transaction successfully saved!";
    } catch (Exception $e) {
        $conn->rollback();
        error_log("INSERT TRANSACTION ERROR: " . $e->getMessage());
        $_SESSION['updateError'] = "Failed to save transaction.";
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>
