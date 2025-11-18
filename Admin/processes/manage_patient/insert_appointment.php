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
    $appointmentServices = $_POST['appointmentServices'] ?? [];
    $dentist_id       = !empty($_POST['appointmentDentist']) && $_POST['appointmentDentist'] !== 'none'
                        ? intval($_POST['appointmentDentist'])
                        : null;
    $appointment_date = $_POST['appointmentDate'] ?? null;
    $appointment_time = $_POST['appointmentTime'] ?? null;
    $notes            = trim($_POST['notes'] ?? '');

    if (!$user_id || !$branch_id || empty($appointmentServices) || !$appointment_date || !$appointment_time) {
        $_SESSION['updateError'] = "Missing required fields.";
        header("Location: " . BASE_URL . "/Admin/pages/patients.php");
        exit();
    }

    try {
        $conn->begin_transaction();

        $appointment_sql = "
            INSERT INTO appointment_transaction 
            (user_id, branch_id, dentist_id, appointment_date, appointment_time, notes, status)
            VALUES (?, ?, ?, ?, ?, ?, 'Booked')
        ";
        $appointment_stmt = $conn->prepare($appointment_sql);
        $appointment_stmt->bind_param(
            "iiisss",
            $user_id,
            $branch_id,
            $dentist_id,
            $appointment_date,
            $appointment_time,
            $notes
        );

        if (!$appointment_stmt->execute()) {
            throw new Exception("Failed to insert appointment: " . $appointment_stmt->error);
        }

        $appointment_transaction_id = $appointment_stmt->insert_id;
        $appointment_stmt->close();

        if (!empty($appointmentServices) && is_array($appointmentServices)) {
            $service_sql = "INSERT INTO appointment_services (appointment_transaction_id, service_id) VALUES (?, ?)";
            $service_stmt = $conn->prepare($service_sql);

            foreach ($appointmentServices as $service_id) {
                $sid = intval($service_id);
                $service_stmt->bind_param("ii", $appointment_transaction_id, $sid);
                $service_stmt->execute();
            }
            $service_stmt->close();
        }

        $update_user = $conn->prepare("UPDATE users SET status = 'Active', date_updated = NOW() WHERE user_id = ?");
        $update_user->bind_param("i", $user_id);
        $update_user->execute();
        $update_user->close();

        $msg = "Your appointment on $appointment_date at $appointment_time was successfully booked!";
        $notif_sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
        $notif_stmt = $conn->prepare($notif_sql);
        $notif_stmt->bind_param("is", $user_id, $msg);
        $notif_stmt->execute();
        $notif_stmt->close();

        $conn->commit();

        $_SESSION['updateSuccess'] = "Appointment booked successfully!";
        header("Location: " . BASE_URL . "/Admin/pages/patients.php");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        error_log("Error booking appointment: " . $e->getMessage());
        $_SESSION['updateError'] = "Failed to book appointment. Please try again.";
        header("Location: " . BASE_URL . "/Admin/pages/patients.php");
        exit();
    }
}

$conn->close();
?>
