<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(["data" => []]);
    exit();
}

$branch_id = $_SESSION['branch_id'];

$sql = "SELECT 
            u.user_id,
            CONCAT(u.first_name, ' ', IFNULL(u.middle_name, ''), ' ', u.last_name) AS name,
            u.gender,
            u.date_of_birth,
            u.email,
            u.contact_number,
            u.status
        FROM users u
        WHERE u.role = 'patient' 
            AND u.status = 'Active'
            AND u.branch_id = ?
        ORDER BY u.user_id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $branch_id);
$stmt->execute();
$result = $stmt->get_result();

$patients = [];
while ($row = $result->fetch_assoc()) {
    $patients[] = [
        $row['user_id'],
        $row['name'],
        '<button class="btn-action" data-type="patient" data-id="'.$row['user_id'].'">Manage</button>'
    ];
}

header('Content-Type: application/json');
echo json_encode(["data" => $patients]);
$conn->close();
