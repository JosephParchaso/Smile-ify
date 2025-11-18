<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    echo json_encode(["data" => []]);
    exit();
}

$sql = "
    SELECT 
        s.service_id,
        s.name,
        s.price,
        s.duration_minutes,
        GROUP_CONCAT(DISTINCT b.name ORDER BY b.name SEPARATOR ', ') AS branches
    FROM service s
    LEFT JOIN branch_service bs ON s.service_id = bs.service_id
    LEFT JOIN branch b ON b.branch_id = bs.branch_id
    GROUP BY s.service_id, s.name, s.price, s.duration_minutes
    ORDER BY s.service_id ASC
";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["error" => "Query failed: " . $conn->error]);
    exit();
}

$services = [];
while ($row = $result->fetch_assoc()) {
    $branchList = $row['branches'] ?: '-';
    $services[] = [
        $row['service_id'],
        htmlspecialchars($row['name']),
        htmlspecialchars($branchList),
        '₱' . number_format($row['price'], 2),
        $row['duration_minutes'] . ' mins',
        '<button class="btn-service" data-id="'.$row['service_id'].'">Manage</button>'
    ];
}

echo json_encode(["data" => $services]);
$conn->close();
?>
