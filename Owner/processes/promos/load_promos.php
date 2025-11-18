<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    echo json_encode(["data" => []]);
    exit();
}

$sql = "
    SELECT 
        p.promo_id, 
        p.name, 
        p.discount_type, 
        p.discount_value,
        GROUP_CONCAT(DISTINCT b.name ORDER BY b.name SEPARATOR ', ') AS branches,
        MIN(bp.start_date) AS start_date, 
        MAX(bp.end_date) AS end_date
    FROM promo p
    LEFT JOIN branch_promo bp ON p.promo_id = bp.promo_id
    LEFT JOIN branch b ON b.branch_id = bp.branch_id
    GROUP BY p.promo_id, p.name, p.discount_type, p.discount_value
    ORDER BY p.promo_id ASC
";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["error" => "Query failed: " . $conn->error]);
    exit();
}

$promos = [];
while ($row = $result->fetch_assoc()) {
    $discount = ($row['discount_type'] === 'percentage')
        ? $row['discount_value'] . '%'
        : '₱' . number_format($row['discount_value'], 2);

    $validity = (!empty($row['start_date']) && !empty($row['end_date']))
        ? date("M d, Y", strtotime($row['start_date'])) . " - " . date("M d, Y", strtotime($row['end_date']))
        : '-';

    $branchList = $row['branches'] ?: '-';

    $promos[] = [
        $row['promo_id'],
        htmlspecialchars($row['name']),
        htmlspecialchars($branchList),
        $discount,
        $validity,
        '<button class="btn-promo" data-id="' . $row['promo_id'] . '">Manage</button>'
    ];
}

echo json_encode(["data" => $promos]);
$conn->close();
?>
