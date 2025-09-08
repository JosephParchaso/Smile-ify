<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "No admin ID provided"]);
    exit();
}

$adminId = intval($_GET['id']);

$sql = "SELECT 
            u.user_id,
            u.username,
            u.last_name,    
            u.first_name,
            u.middle_name,
            CONCAT(u.last_name, ', ', u.first_name, ' ', IFNULL(u.middle_name, '')) AS name,
            u.gender,
            u.date_of_birth,
            u.email,
            u.contact_number,
            u.address,
            b.branch_id,
            b.name AS branch,
            u.status,
            date_started,
            date_created
        FROM users u
        LEFT JOIN branch b ON u.branch_id = b.branch_id
        WHERE u.user_id = ? 
        AND u.role = 'admin'
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $adminId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["error" => "Admin not found"]);
}

$conn->close();
