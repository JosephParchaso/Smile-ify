<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $appointment_id  = intval($_POST['appointment_transaction_id'] ?? 0);
    $prescription_id = intval($_POST['prescription_id'] ?? 0);
    $drug        = trim($_POST['drug'] ?? '');
    $route       = trim($_POST['route'] ?? '');
    $frequency   = trim($_POST['frequency'] ?? '');
    $dosage      = trim($_POST['dosage'] ?? '');
    $duration    = trim($_POST['duration'] ?? '');
    $instructions= trim($_POST['instructions'] ?? '');

    if (!$appointment_id || !$prescription_id || !$drug || !$route || !$frequency || !$dosage || !$duration || !$instructions) {
        $_SESSION['updateError'] = "Missing required prescription fields.";
        header("Location: " . BASE_URL . "/Admin/pages/appointments.php");
        exit();
    }

    try {
        $stmt = $conn->prepare("
            UPDATE dental_prescription
            SET drug=?, route=?, frequency=?, dosage=?, duration=?, instructions=?
            WHERE prescription_id=? AND appointment_transaction_id=?
        ");
        $stmt->bind_param("ssssssii", $drug, $route, $frequency, $dosage, $duration, $instructions, $prescription_id, $appointment_id);
        $stmt->execute();
        $stmt->close();

        $_SESSION['updateSuccess'] = "Prescription updated successfully!";
    } catch (Exception $e) {
        error_log("Error updating prescription: " . $e->getMessage());
        $_SESSION['updateError'] = "Failed to update prescription.";
    }

    header("Location: " . BASE_URL . "/Admin/pages/appointments.php");
    exit();
}
