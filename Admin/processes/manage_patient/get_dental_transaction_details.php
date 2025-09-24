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

$transactionId = $_GET['id'] ?? null;
if (!$transactionId || !is_numeric($transactionId)) {
    echo json_encode(['error' => 'Invalid transaction ID']);
    exit();
}

$sql = "SELECT 
            dt.dental_transaction_id,
            dt.notes,
            dt.amount_paid,
            dt.is_swelling,
            dt.is_sensitive,
            dt.is_bleeding,
            dt.date_created,
            dt.prescription_downloaded,

            a.appointment_transaction_id,
            a.appointment_date,
            a.appointment_time,

            s.name AS service,
            b.name AS branch,
            CONCAT('Dr. ', d.last_name, ', ', d.first_name, ' ', IFNULL(d.middle_name, '')) AS dentist,

            dv.body_temp,
            dv.pulse_rate,
            dv.respiratory_rate,
            dv.blood_pressure,
            dv.height,
            dv.weight,

            u.last_name AS patient_last_name,
            u.first_name AS patient_first_name,
            u.middle_name AS patient_middle_name,
            u.date_of_birth AS patient_dob,
            u.gender AS patient_gender,

            d.license_number,
            d.signature_image
        FROM dental_transaction dt
        INNER JOIN appointment_transaction a 
            ON dt.appointment_transaction_id = a.appointment_transaction_id
        LEFT JOIN service s 
            ON a.service_id = s.service_id
        LEFT JOIN branch b 
            ON a.branch_id = b.branch_id
        LEFT JOIN dentist d 
            ON d.dentist_id = COALESCE(dt.dentist_id, a.dentist_id)
        LEFT JOIN dental_vital dv
            ON dv.appointment_transaction_id = a.appointment_transaction_id
        LEFT JOIN users u
            ON a.user_id = u.user_id
        WHERE dt.dental_transaction_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $transactionId);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo json_encode(['error' => 'Transaction not found']);
    exit();
}

$presSql = "SELECT drug, route, frequency, dosage, duration, instructions
            FROM dental_prescription
            WHERE appointment_transaction_id = ?";
$stmtPres = $conn->prepare($presSql);
$stmtPres->bind_param("i", $data['appointment_transaction_id']);
$stmtPres->execute();
$resPres = $stmtPres->get_result();

$prescriptions = [];
while ($row = $resPres->fetch_assoc()) {
    $prescriptions[] = $row;
}
$data['prescriptions'] = $prescriptions;

echo json_encode($data);
$conn->close();
