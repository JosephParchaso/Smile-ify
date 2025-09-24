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

$prescriptionId = $_GET['id'] ?? null;
if (!$prescriptionId || !is_numeric($prescriptionId)) {
    echo json_encode(['error' => 'Invalid prescription ID']);
    exit();
}

$sql = "SELECT 
            pr.prescription_id,
            pr.appointment_id,
            pr.drug,
            pr.route,
            pr.frequency,
            pr.dosage,
            pr.duration,
            pr.instructions,
            pr.date_created,
            CONCAT('Dr. ', d.last_name, ', ', d.first_name, ' ', IFNULL(d.middle_name, '')) AS dentist,
            p.first_name AS patient_first,
            p.last_name AS patient_last
        FROM prescription pr
        LEFT JOIN appointment_transaction a ON pr.appointment_id = a.appointment_transaction_id
        LEFT JOIN dentist d ON a.dentist_id = d.dentist_id
        LEFT JOIN patient p ON a.patient_id = p.patient_id
        WHERE pr.prescription_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $prescriptionId);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo json_encode(['error' => 'Prescription not found']);
    exit();
}

echo json_encode($data);
$conn->close();
