<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

$userID = $_SESSION['user_id'];

$sql = "SELECT 
            first_name, 
            middle_name, 
            last_name, 
            gender, 
            date_of_birth, 
            email, 
            contact_number,
            address, 
            date_created,
            date_updated 
        FROM users 
        WHERE user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $profile = [
        'full_name' => $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'],
        'gender' => ucfirst($row['gender']),
        'date_of_birth' => $row['date_of_birth'],
        'email' => $row['email'],
        'contact_number' => $row['contact_number'],
        'address' => $row['address'],
        'joined' => date("F d, Y", strtotime($row['date_created'])),
        "date_updated"   => $row['date_updated'] ? date("F d, Y", strtotime($row['date_updated'])) : "-",
    ];

    header('Content-Type: application/json');
    echo json_encode($profile);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'User not found.']);
}

$conn->close();
?>
