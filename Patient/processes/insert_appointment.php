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
    $appointmentServices = $_POST['appointmentServices'];
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
            (user_id, branch_id, dentist_id, appointment_date, appointment_time, notes, status)
            VALUES (?, ?, ?, ?, ?, ?, 'Booked')";
        $appointment_stmt = $conn->prepare($appointment_sql);
        $appointment_stmt->bind_param(
            "iiisss",
            $user_id,
            $appointmentBranch,
            $appointmentDentist,
            $appointmentDate,
            $appointmentTime,
            $notes
        );

        if (!$appointment_stmt->execute()) {
            throw new Exception("Failed to book appointment: " . $appointment_stmt->error);
        }

        $appointment_transaction_id = $appointment_stmt->insert_id;

        if (!empty($appointmentServices) && is_array($appointmentServices)) {
            $service_sql = "INSERT INTO appointment_services (appointment_transaction_id, service_id) VALUES (?, ?)";
            $service_stmt = $conn->prepare($service_sql);

            foreach ($appointmentServices as $service_id) {
                $service_stmt->bind_param("ii", $appointment_transaction_id, $service_id);
                $service_stmt->execute();
            }
            $service_stmt->close();
        } else {
            throw new Exception("No services selected for appointment.");
        }

        $user_update_sql = "UPDATE users SET date_updated = NOW() WHERE user_id = ?";
        $user_update_stmt = $conn->prepare($user_update_sql);
        $user_update_stmt->bind_param("i", $user_id);
        $user_update_stmt->execute();

        $notif_sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
        $notif_stmt = $conn->prepare($notif_sql);
        $notif_message = "Your appointment on $appointmentDate at $appointmentTime was successfully booked!";
        $notif_stmt->bind_param("is", $user_id, $notif_message);
        $notif_stmt->execute();

        $conn->commit();

        $_SESSION['updateSuccess'] = "Appointment booked successfully.";
        header("Location: " . BASE_URL . "/Patient/pages/calendar.php");
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        error_log("Error booking appointment: " . $e->getMessage());
        $_SESSION['updateError'] = "Failed to book appointment. Please try again.";
        header("Location: " . BASE_URL . "/Patient/index.php");
        exit;
    }
} else {
    header("Location: " . BASE_URL . "/Patient/index.php");
    exit;
}

$conn->close();
?>
