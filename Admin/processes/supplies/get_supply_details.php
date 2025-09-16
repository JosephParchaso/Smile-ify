<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "No supply ID provided"]);
    exit();
}

$supplyId = intval($_GET['id']);

$sql = "SELECT 
            supply_id,
            name,
            description,
            category,
            unit,
            quantity,
            reorder_level,
            expiration_date,
            branch_id,
            status,
            date_created,
            date_updated
        FROM supply
        WHERE supply_id = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $supplyId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["error" => "Supply not found"]);
}

$conn->close();
