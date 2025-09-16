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
            supply_id,
            name,
            quantity,
            reorder_level,
            status,
            date_created
        FROM supply
        WHERE branch_id = ?
        ORDER BY date_created DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $branch_id);
$stmt->execute();
$result = $stmt->get_result();

$supplies = [];
while ($row = $result->fetch_assoc()) {
    $supplies[] = [
        $row['supply_id'],
        $row['name'],
        $row['quantity'],
        $row['reorder_level'],
        $row['status'],
        $row['date_created'],
        '<button class="btn-supply" data-type="supply" data-id="'.$row['supply_id'].'">Manage</button>'
    ];
}

header('Content-Type: application/json');
echo json_encode(["data" => $supplies]);
$conn->close();
