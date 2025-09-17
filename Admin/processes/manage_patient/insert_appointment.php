<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id          = intval($_POST['user_id'] ?? 0);
    $branch_id        = intval($_POST['appointmentBranch'] ?? 0);
    $service_id       = intval($_POST['appointmentService'] ?? 0);
    $dentist_id       = !empty($_POST['appointmentDentist']) && $_POST['appointmentDentist'] !== 'none'
                        ? intval($_POST['appointmentDentist'])
                        : null;
    $appointment_date = $_POST['appointmentDate'] ?? null;
    $appointment_time = $_POST['appointmentTime'] ?? null;
    $notes            = trim($_POST['notes'] ?? '');

    if (!$user_id || !$branch_id || !$service_id || !$appointment_date || !$appointment_time) {
        $_SESSION['updateError'] = "Missing required fields.";
        header("Location: " . BASE_URL . "/Admin/pages/patients.php");
        exit();
    }

    try {
        $stmt = $conn->prepare("
            INSERT INTO appointment_transaction 
            (user_id, branch_id, service_id, dentist_id, appointment_date, appointment_time, notes, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')
        ");
        $stmt->bind_param(
            "iiiisss",
            $user_id, $branch_id, $service_id, $dentist_id,
            $appointment_date, $appointment_time, $notes
        );
        $stmt->execute();
        $stmt->close();

        $msg = "Your appointment on $appointment_date at $appointment_time was successfully booked!";
        $notif_sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
        $notif_stmt = $conn->prepare($notif_sql);
        $notif_stmt->bind_param("is", $user_id, $msg);
        $notif_stmt->execute();
        $notif_stmt->close();

        $_SESSION['updateSuccess'] = "Appointment booked successfully!";
        header("Location: " . BASE_URL . "/Admin/pages/patients.php");
        exit();

    } catch (Exception $e) {
        error_log("Error booking appointment: " . $e->getMessage());
        $_SESSION['updateError'] = "Failed to book appointment. Please try again.";
        header("Location: " . BASE_URL . "/Admin/pages/patients.php");
        exit();
    }
}
