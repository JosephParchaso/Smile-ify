<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    echo json_encode(["data" => []]);
    exit();
}

$sql = "SELECT service_id, name, price, duration_minutes 
        FROM service 
        ORDER BY service_id ASC";

$result = $conn->query($sql);

$services = [];
while ($row = $result->fetch_assoc()) {
    $services[] = [
        $row['service_id'],
        htmlspecialchars($row['name']),
        number_format($row['price'], 2),
        $row['duration_minutes'] . ' mins',
        '<button class="btn-service" data-id="'.$row['service_id'].'">Manage</button>'
    ];
}

header('Content-Type: application/json');
echo json_encode(["data" => $services]);
$conn->close();
