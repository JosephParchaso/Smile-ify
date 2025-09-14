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
    echo json_encode(["error" => "No patient ID provided"]);
    exit();
}

$patientId = intval($_GET['id']);

$sql = "SELECT 
            u.user_id,
            CONCAT(u.last_name, ', ', u.first_name, ' ', IFNULL(u.middle_name, '')) AS name,
            u.last_name, u.first_name, u.middle_name,
            u.gender,
            u.date_of_birth,
            u.email,
            u.contact_number,
            u.address,
            u.status,
            u.date_created
        FROM users u
        WHERE u.user_id = ? 
        AND u.role = 'patient'
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patientId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["error" => "Patient not found"]);
}

$conn->close();
