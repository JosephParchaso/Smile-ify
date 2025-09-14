<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "No booking ID provided"]);
    exit();
}

$bookingId = intval($_GET['id']);

$sql = "SELECT 
            a.appointment_transaction_id,
            CONCAT(p.last_name, ', ', p.first_name, ' ', IFNULL(p.middle_name, '')) AS patient_name,
            CONCAT(d.last_name, ', ', d.first_name, ' ', IFNULL(d.middle_name, '')) AS dentist,
            b.name AS branch,
            s.name AS service,
            a.appointment_date,
            a.appointment_time,
            a.notes,
            a.status
        FROM appointment_transactions a
        LEFT JOIN users p ON a.patient_id = p.user_id
        LEFT JOIN users d ON a.dentist_id = d.user_id
        LEFT JOIN branch b ON a.branch_id = b.branch_id
        LEFT JOIN services s ON a.service_id = s.service_id
        WHERE a.appointment_transaction_id = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bookingId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["error" => "Booking not found"]);
}

$conn->close();
