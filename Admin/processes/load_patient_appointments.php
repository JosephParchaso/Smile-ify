<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    exit('Unauthorized');
}

$branch_id = $_SESSION['branch_id'] ?? null;

if (!$branch_id) {
    http_response_code(400);
    exit('Branch ID not found in session');
}

$sql = "SELECT DISTINCT 
            a.appointment_transaction_id,
            CONCAT(u.first_name, ' ', u.last_name) AS patient,
            b.name AS branch,
            s.name AS service,
            CONCAT(d.last_name, ', ', d.first_name) AS dentist,
            a.appointment_date,
            a.appointment_time
        FROM appointment_transaction a
        LEFT JOIN branch b ON a.branch_id = b.branch_id
        LEFT JOIN service s ON a.service_id = s.service_id
        LEFT JOIN dentist d ON a.dentist_id = d.dentist_id
        LEFT JOIN users u ON a.user_id = u.user_id
        WHERE a.branch_id = ?
        ORDER BY a.appointment_date, a.appointment_time";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $branch_id);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'id' => $row['appointment_transaction_id'],
        'title' => $row['service'] . ' - ' . $row['patient'],
        'start' => $row['appointment_date'] . 'T' . $row['appointment_time'],
        'branch' => $row['branch'],
        'service' => $row['service'],
        'dentist' => $row['dentist'],
        'patient' => $row['patient']
    ];
}

header('Content-Type: application/json');
echo json_encode($events);

$stmt->close();
$conn->close();
