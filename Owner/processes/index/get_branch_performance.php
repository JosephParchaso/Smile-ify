<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

try {
    $sql = "
        SELECT 
            b.name AS name,
            IFNULL(SUM(dt.total), 0) AS total_revenue
        FROM branch b
        LEFT JOIN appointment_transaction at ON b.branch_id = at.branch_id
        LEFT JOIN dental_transaction dt ON at.appointment_transaction_id = dt.appointment_transaction_id
        GROUP BY b.branch_id
        ORDER BY total_revenue DESC
    ";

    $result = $conn->query($sql);
    $branches = [];

    while ($row = $result->fetch_assoc()) {
        $branches[] = [
            'name' => $row['name'],
            'total_revenue' => (float)$row['total_revenue']
        ];
    }

    echo json_encode(['branches' => $branches]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
