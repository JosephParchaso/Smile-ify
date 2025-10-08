<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(["data" => []]);
    exit();
}

$appointmentID = $_GET['appointment_id'] ?? null;
if (!$appointmentID || !is_numeric($appointmentID)) {
    echo json_encode(["data" => []]);
    exit();
}

$sql = "SELECT 
            t.dental_transaction_id,
            t.appointment_transaction_id,
            CONCAT('Dr. ', d.last_name, ', ', d.first_name, ' ', IFNULL(d.middle_name, '')) AS dentist,
            t.amount_paid
        FROM dental_transaction t
        LEFT JOIN dentist d ON t.dentist_id = d.dentist_id
        WHERE t.appointment_transaction_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $appointmentID);
$stmt->execute();
$result = $stmt->get_result();

$transactions = [];
while ($row = $result->fetch_assoc()) {
    $transactions[] = [
        $row['dental_transaction_id '],
        $row['dentist'] ?: '—',
        number_format($row['amount_paid'], 2),
        '<button class="btn-action" data-type="dental_transaction" data-id="'.$row['dental_transaction_id '].'">Manage</button>'
    ];
}

header('Content-Type: application/json');
echo json_encode(["data" => $transactions]);
$conn->close();
