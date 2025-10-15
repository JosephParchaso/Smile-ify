<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentId = $_POST['appointment_id'] ?? null;
    $action = $_POST['status'] ?? null;
    $userId = $_POST['user_id'] ?? null;

    if (!$appointmentId || !$userId || $action !== 'cancel') {
        $_SESSION['updateError'] = "Invalid request. Missing or incorrect fields.";
        header("Location: " . BASE_URL . "/Admin/pages/patients.php");
        exit;
    }

    try {
        $conn->begin_transaction();

        $check = $conn->prepare("
            SELECT appointment_date, appointment_time, status, user_id 
            FROM appointment_transaction 
            WHERE appointment_transaction_id = ?
        ");
        $check->bind_param("i", $appointmentId);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("Appointment not found.");
        }

        $row = $result->fetch_assoc();
        $check->close();

        if (strtolower($row['status']) === 'cancelled') {
            throw new Exception("This appointment has already been cancelled.");
        }

        if (strtolower($row['status']) === 'completed') {
            throw new Exception("This appointment has already been completed and cannot be cancelled.");
        }

        $stmt = $conn->prepare("
            UPDATE appointment_transaction
            SET status = 'Cancelled', date_updated = NOW()
            WHERE appointment_transaction_id = ?
        ");
        $stmt->bind_param("i", $appointmentId);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update appointment: " . $stmt->error);
        }
        $stmt->close();

        $formattedDate = date("F j, Y", strtotime($row['appointment_date']));
        $formattedTime = date("g:i A", strtotime($row['appointment_time']));
        $message = "Your appointment ($formattedDate at $formattedTime) has been cancelled.";

        $patientId = $row['user_id'];

        $notif_stmt = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
        $notif_stmt->bind_param("is", $patientId, $message);
        if (!$notif_stmt->execute()) {
            throw new Exception("Failed to insert notification: " . $notif_stmt->error);
        }
        $notif_stmt->close();

        $conn->commit();

        $_SESSION['updateSuccess'] = "Appointment has been cancelled successfully.";
        header("Location: " . BASE_URL . "/Admin/pages/patients.php");
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['updateError'] = "Error: " . $e->getMessage();
        header("Location: " . BASE_URL . "/Admin/pages/patients.php");
        exit;
    }
} else {
    header("Location: " . BASE_URL . "/index.php");
    exit;
}

$conn->close();
?>
