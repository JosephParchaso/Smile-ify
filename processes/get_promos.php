<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

$sql = "
    SELECT 
        p.promo_id,
        p.name,
        p.image_path,
        bp.start_date,
        bp.end_date
    FROM promo p
    INNER JOIN branch_promo bp ON p.promo_id = bp.promo_id
    WHERE bp.status = 'Active'
        AND (bp.start_date IS NULL OR bp.start_date <= CURDATE())
        AND (bp.end_date IS NULL OR bp.end_date >= CURDATE())
    ORDER BY bp.date_created DESC
";

$result = $conn->query($sql);

$promos = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $promos[] = $row;
    }
}

echo json_encode($promos);
