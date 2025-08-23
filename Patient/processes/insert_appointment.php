<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $appointmentBranch = $_POST['appointmentBranch'];
    $appointmentService = $_POST['appointmentService'];
    $appointmentDentist = $_POST['appointmentDentist'];
    $appointmentDate = $_POST['appointmentDate'];
    $appointmentTime = $_POST['appointmentTime'];
    $notes = $_POST['notes'];

    if ($appointmentDentist === "none" || empty($appointmentDentist)) {
        $appointmentDentist = null;
    }

    try {
        $conn->begin_transaction();

        $appointment_sql = "INSERT INTO appointment_transaction 
            (user_id, branch_id, service_id, dentist_id, appointment_date, appointment_time, notes, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')";

        $appointment_stmt = $conn->prepare($appointment_sql);
        $appointment_stmt->bind_param("iiissss", $user_id, $appointmentBranch, $appointmentService, $appointmentDentist, $appointmentDate, $appointmentTime, $notes);

        if (!$appointment_stmt->execute()) {
            throw new Exception("Failed to book appointment: " . $appointment_stmt->error);
        }

        $notif_sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
        $notif_stmt = $conn->prepare($notif_sql);
        $notif_message = "Your appointment on $appointmentDate at $appointmentTime was successfully booked!";
        $notif_stmt->bind_param("is", $user_id, $notif_message);
        $notif_stmt->execute();

        $conn->commit();

        $_SESSION['success_msg'] = "Appointment booked successfully.";
        header("Location: " . BASE_URL . "/Patient/pages/schedule.php");
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        error_log("Error booking appointment: " . $e->getMessage());
        $_SESSION['error_msg'] = "Failed to book appointment. Please try again.";
        header("Location: " . BASE_URL . "/Patient/index.php");
        exit;
    }
} else {
    header("Location: " . BASE_URL . "/Patient/index.php");
    exit;
}

$conn->close();
