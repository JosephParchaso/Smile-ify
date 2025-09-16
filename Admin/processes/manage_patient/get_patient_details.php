<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$userId = $_GET['id'] ?? null;

if (!$userId) {
    http_response_code(400);
    echo json_encode(['error' => 'No patient ID provided']);
    exit();
}

$sql = "SELECT user_id, first_name, middle_name, last_name, gender, date_of_birth, email, contact_number, address, date_created, status 
        FROM users 
        WHERE user_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $conn->error]);
    exit();
}

$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $data = [
        "full_name"      => trim($row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name']),
        "gender"         => $row['gender'] ?? "-",
        "date_of_birth"  => $row['date_of_birth'] ?? "-",
        "email"          => $row['email'] ?? "-",
        "contact_number" => $row['contact_number'] ?? "-",
        "address"        => $row['address'] ?? "-",
        "joined"         => $row['date_created'] ? date("F d, Y", strtotime($row['date_created'])) : "-",
        "status"         => ucfirst($row['status'])
    ];

    echo json_encode($data);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Patient not found']);
}

$stmt->close();
$conn->close();
