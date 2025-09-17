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
            u.email,
            u.contact_number,
            u.branch_id,
            COALESCE(b.name, '-') AS branch_name,
            u.status
        FROM users u
        LEFT JOIN branch b ON u.branch_id = b.branch_id
        WHERE u.role = 'patient' 
            AND u.status = 'Inactive'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$inactive = [];
while ($row = $result->fetch_assoc()) {
    $inactive[] = [
        $row['user_id'],
        $row['name'],
        $row['branch_name'],
        '<a href="' . BASE_URL . '/Admin/pages/manage_patient.php?id=' . $row['user_id'] . '&tab=inactive" class="manage-action">Manage</a>'
    ];
}

header('Content-Type: application/json');
echo json_encode(["data" => $inactive]);
$conn->close();
