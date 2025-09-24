<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $appointment_id   = intval($_POST['appointment_transaction_id'] ?? 0);
    $body_temp        = $_POST['body_temp'] ?? null;
    $pulse_rate       = $_POST['pulse_rate'] ?? null;
    $respiratory_rate = $_POST['respiratory_rate'] ?? null;
    $blood_pressure   = $_POST['blood_pressure'] ?? null;
    $height           = $_POST['height'] ?? null;
    $weight           = $_POST['weight'] ?? null;

    if (!$appointment_id || !$body_temp || !$pulse_rate || !$respiratory_rate || !$blood_pressure || !$height || !$weight) {
        $_SESSION['updateError'] = "Missing required vital fields.";
        header("Location: " . BASE_URL . "/Admin/pages/manage_appointment.php?id=" . $appointment_id . "&tab=vitals");
        exit();
    }

    try {
        $stmt = $conn->prepare("
            INSERT INTO dental_vital 
            (appointment_transaction_id, body_temp, pulse_rate, respiratory_rate, blood_pressure, height, weight, date_created)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param("idiisdd", $appointment_id, $body_temp, $pulse_rate, $respiratory_rate, $blood_pressure, $height, $weight);
        $stmt->execute();
        $stmt->close();

        $_SESSION['updateSuccess'] = "Vitals added successfully!";
    } catch (Exception $e) {
        error_log("Error inserting vitals: " . $e->getMessage());
        $_SESSION['updateError'] = "Failed to add vitals.";
    }

    header("Location: " . BASE_URL . "/Admin/pages/manage_appointment.php?id=" . $appointment_id . "&tab=vitals");
    exit();
}
