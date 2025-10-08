<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

if (!isset($_GET['branch_id'])) {
    echo json_encode(["error" => "Missing branch_id"]);
    exit;
}

$branchId = intval($_GET['branch_id']);

$stmt = $conn->prepare("
    SELECT s.service_id, s.name, s.price
    FROM service s
    INNER JOIN branch_service bs ON s.service_id = bs.service_id
    WHERE bs.branch_id = ? AND bs.status = 'Active'
    ORDER BY s.name ASC
");
$stmt->bind_param("i", $branchId);
$stmt->execute();
$result = $stmt->get_result();

$services = [];
while ($row = $result->fetch_assoc()) {
    $services[] = [
        'service_id' => $row['service_id'],
        'name'       => $row['name'],
        'price'      => $row['price'] ?? 0
    ];
}

echo json_encode($services);

$stmt->close();
$conn->close();
?>
