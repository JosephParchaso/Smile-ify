<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['error' => 'Invalid promo ID.']);
    exit;
}

$promo_id = intval($_GET['id']);

$sql = "
    SELECT 
        p.promo_id,
        p.name,
        p.image_path,
        p.description,
        p.discount_type,
        p.discount_value,
        bp.start_date,
        bp.end_date,
        bp.status
    FROM promo p
    INNER JOIN branch_promo bp ON p.promo_id = bp.promo_id
    WHERE p.promo_id = ?
    LIMIT 1
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $promo_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'Promo not found.']);
}

$stmt->close();
$conn->close();
