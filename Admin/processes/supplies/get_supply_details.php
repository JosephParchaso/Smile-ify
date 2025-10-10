<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "No supply ID provided"]);
    exit();
}

$branch_id = $_SESSION['branch_id'] ?? null;
$supplyId = intval($_GET['id']);

if (!$branch_id) {
    echo json_encode(["error" => "Branch not set"]);
    exit();
}

$sql = "SELECT 
            s.supply_id,
            s.name,
            s.description,
            s.category,
            s.unit,
            bs.quantity,
            bs.reorder_level,
            bs.expiration_date,
            bs.status,
            bs.date_created,
            bs.date_updated
        FROM supply s
        INNER JOIN branch_supply bs ON s.supply_id = bs.supply_id
        WHERE s.supply_id = ? AND bs.branch_id = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $supplyId, $branch_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["error" => "Supply not found"]);
}

$conn->close();
