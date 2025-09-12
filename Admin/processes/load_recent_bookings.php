<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(["data" => []]);
    exit();
}

$branch_id = $_SESSION['branch_id'];

$sql = "SELECT 
            a.appointment_transaction_id,
            CONCAT(u.first_name, ' ', u.last_name) AS patient,
            b.name AS branch,
            s.name AS service,
            CONCAT(d.first_name, ' ', d.last_name) AS dentist,
            a.appointment_date,
            a.appointment_time,
            a.date_created,
            a.status
        FROM appointment_transaction a
        JOIN users u ON a.user_id = u.user_id
        LEFT JOIN branch b ON a.branch_id = b.branch_id
        LEFT JOIN service s ON a.service_id = s.service_id
        LEFT JOIN users d ON a.dentist_id = d.user_id
        WHERE a.branch_id = ?
        AND u.role = 'patient'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $branch_id);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];
while ($row = $result->fetch_assoc()) {
    $bookings[] = [
        $row['appointment_transaction_id'],
        $row['patient'],
        $row['service'] ?: '-',
        $row['dentist'] ?: '-',
        $row['appointment_date'],
        $row['appointment_time'],
        $row['status'],
        '<button class="btn-action" data-type="booking" data-id="'.$row['appointment_transaction_id'].'">Manage</button>'
    ];
}

header('Content-Type: application/json');
echo json_encode(["data" => $bookings]);
$conn->close();
