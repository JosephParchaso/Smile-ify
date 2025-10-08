<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    echo json_encode(["data" => []]);
    exit();
}

$userID = $_SESSION['user_id'];

$sql = "SELECT 
            dt.dental_transaction_id,
            b.name AS branch,
            s.name AS service,
            CONCAT('Dr. ', d.last_name, ', ', d.first_name, ' ', IFNULL(d.middle_name, '')) AS dentist,
            a.appointment_date,
            a.appointment_time,
            dt.amount_paid,
            dt.date_created
        FROM dental_transaction dt
        INNER JOIN appointment_transaction a 
            ON dt.appointment_transaction_id = a.appointment_transaction_id
        LEFT JOIN branch b 
            ON a.branch_id = b.branch_id
        LEFT JOIN service s 
            ON a.service_id = s.service_id
        LEFT JOIN dentist d 
            ON d.dentist_id = COALESCE(dt.dentist_id, a.dentist_id)
        WHERE a.user_id = ?
        ORDER BY dt.date_created DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

$transactions = [];
while ($row = $result->fetch_assoc()) {
    $transactions[] = [
        $row['dentist'] ?: '-',
        $row['branch'] ?: '-',
        $row['service'] ?: '-',
        $row['appointment_date'],
        substr($row['appointment_time'], 0, 5),
        number_format($row['amount_paid'], 2),
        '<button class="btn-action" data-type="transaction" data-id="'.$row['dental_transaction_id'].'">Manage</button>',
        $row['date_created']
    ];
}

header('Content-Type: application/json');
echo json_encode(["data" => $transactions]);
$conn->close();
