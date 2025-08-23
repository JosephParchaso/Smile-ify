<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

$userID = $_SESSION['user_id'];

$sql = "SELECT DISTINCT
            a.appointment_transaction_id,
            b.name AS branch,
            s.name AS service,
            CONCAT(d.last_name, ', ', d.first_name) AS dentist,
            a.appointment_date,
            a.appointment_time,
            a.notes
        FROM appointment_transaction a
        LEFT JOIN branch b ON a.branch_id = b.branch_id
        LEFT JOIN service s ON a.service_id = s.service_id
        LEFT JOIN dentist d ON a.dentist_id = d.dentist_id
        WHERE a.user_id = ?
        ORDER BY a.appointment_date, a.appointment_time";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'id' => $row['appointment_transaction_id'],
        'title' => $row['service'],
        'start' => $row['appointment_date'] . 'T' . $row['appointment_time'],
        'branch' => $row['branch'],
        'service' => $row['service'],
        'dentist' => $row['dentist'],
        'notes' => $row['notes']
    ];
}

header('Content-Type: application/json');
echo json_encode($events);
$conn->close();
?>