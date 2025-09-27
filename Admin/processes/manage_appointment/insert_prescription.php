<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $appointment_id = intval($_POST['appointment_transaction_id'] ?? 0);
    $drug        = trim($_POST['drug'] ?? '');
    $frequency   = trim($_POST['frequency'] ?? '');
    $dosage      = trim($_POST['dosage'] ?? '');
    $duration    = trim($_POST['duration'] ?? '');
    $quantity    = trim($_POST['quantity'] ?? '');
    $instructions= trim($_POST['instructions'] ?? '');

    if (!$appointment_id || !$drug || !$frequency || !$dosage || !$duration || !$quantity || !$instructions) {
        $_SESSION['updateError'] = "Missing required prescription fields.";
        header("Location: " . BASE_URL . "/Admin/pages/manage_appointment.php?id=" . $appointment_id . "&backTab=recent&tab=prescriptions");
        exit();
    }

    try {
        $stmt = $conn->prepare("
            INSERT INTO dental_prescription 
            (appointment_transaction_id, drug, frequency, dosage, duration, quantity, instructions, date_created)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param("issssss", $appointment_id, $drug, $frequency, $dosage, $duration, $quantity, $instructions);
        $stmt->execute();
        $stmt->close();

        $_SESSION['updateSuccess'] = "Prescription added successfully!";
    } catch (Exception $e) {
        error_log("Error inserting prescription: " . $e->getMessage());
        $_SESSION['updateError'] = "Failed to add prescription.";
    }

    header("Location: " . BASE_URL . "/Admin/pages/manage_appointment.php?id=" . $appointment_id . "&backTab=recent&tab=prescriptions");
    exit();
}
