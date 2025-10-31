<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transaction_id = $_POST['dental_transaction_id'] ?? null;
    $fitness_status = trim($_POST['fitness_status'] ?? '');
    $diagnosis      = trim($_POST['diagnosis'] ?? '');
    $remarks        = trim($_POST['remarks'] ?? '');

    if (!$transaction_id || $fitness_status === '' || $diagnosis === '' || $remarks === '') {
        $_SESSION['updateError'] = "All fields are required.";
        header("Location: " . BASE_URL . "/Admin/pages/patients.php");
        exit();
    }

    $getPatient = $conn->prepare("
        SELECT at.user_id, at.appointment_date, at.appointment_time
        FROM dental_transaction dt
        JOIN appointment_transaction at 
            ON at.appointment_transaction_id = dt.appointment_transaction_id
        WHERE dt.dental_transaction_id = ?
    ");
    $getPatient->bind_param("i", $transaction_id);
    $getPatient->execute();
    $result = $getPatient->get_result();
    $patientData = $result->fetch_assoc();
    $getPatient->close();

    if (!$patientData) {
        $_SESSION['updateError'] = "Unable to find patient for this transaction.";
        header("Location: " . BASE_URL . "/Admin/pages/patients.php");
        exit();
    }

    $patientId = $patientData['user_id'];
    $appointmentDate = date("F j, Y", strtotime($patientData['appointment_date']));
    $appointmentTime = date("g:i A", strtotime($patientData['appointment_time']));

    $query = "
        UPDATE dental_transaction
        SET fitness_status   = ?,
            diagnosis        = ?,
            remarks          = ?,
            med_cert_status  = 'Eligible',
            date_updated     = NOW()
        WHERE dental_transaction_id = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $fitness_status, $diagnosis, $remarks, $transaction_id);

    if ($stmt->execute()) {
        $message = "Your medical certificate request from your appointment on $appointmentDate at $appointmentTime has been approved.";
        $notif = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
        $notif->bind_param("is", $patientId, $message);
        $notif->execute();
        $notif->close();

        $_SESSION['updateSuccess'] = "Medical certificate issued successfully and patient notified.";
    } else {
        $_SESSION['updateError'] = "Error issuing medical certificate: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: " . BASE_URL . "/Admin/pages/manage_patient.php?id=" . urlencode($patientId) . "&tab=dental_transaction");
    exit();
} else {
    header("Location: " . BASE_URL . "/Admin/pages/patients.php");
    exit();
}
?>
