<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$appointmentId = $_GET['id'] ?? null;
if (!$appointmentId || !is_numeric($appointmentId)) {
    echo json_encode(['error' => 'Invalid appointment ID']);
    exit();
}

$sql = "SELECT 
            a.appointment_transaction_id,
            a.appointment_date,
            a.appointment_time,
            a.notes,
            a.status,
            a.date_created,
            s.name AS service,
            b.name AS branch,
            CONCAT('Dr. ', d.last_name, ', ', d.first_name, ' ', IFNULL(d.middle_name, '')) AS dentist
        FROM appointment_transaction a
        LEFT JOIN service s ON a.service_id = s.service_id
        LEFT JOIN branch b ON a.branch_id = b.branch_id
        LEFT JOIN dentist d ON a.dentist_id = d.dentist_id
        WHERE a.appointment_transaction_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $appointmentId);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo json_encode(['error' => 'Appointment not found']);
    exit();
}

echo json_encode($data);
$conn->close();
