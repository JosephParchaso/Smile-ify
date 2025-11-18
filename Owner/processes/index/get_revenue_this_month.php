<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

try {
    $sqlCurrent = "
        SELECT IFNULL(SUM(dt.total), 0) AS current_revenue
        FROM dental_transaction dt
        INNER JOIN appointment_transaction a 
            ON dt.appointment_transaction_id = a.appointment_transaction_id
        WHERE YEAR(a.appointment_date) = YEAR(CURDATE())
            AND MONTH(a.appointment_date) = MONTH(CURDATE())
    ";
    $currentResult = $conn->query($sqlCurrent);
    $currentRevenue = ($currentResult->fetch_assoc())['current_revenue'] ?? 0;

    $sqlLast = "
        SELECT IFNULL(SUM(dt.total), 0) AS last_revenue
        FROM dental_transaction dt
        INNER JOIN appointment_transaction a 
            ON dt.appointment_transaction_id = a.appointment_transaction_id
        WHERE YEAR(a.appointment_date) = YEAR(CURDATE() - INTERVAL 1 MONTH)
            AND MONTH(a.appointment_date) = MONTH(CURDATE() - INTERVAL 1 MONTH)
    ";
    $lastResult = $conn->query($sqlLast);
    $lastRevenue = ($lastResult->fetch_assoc())['last_revenue'] ?? 0;

    $change = $lastRevenue > 0 
        ? (($currentRevenue - $lastRevenue) / $lastRevenue) * 100
        : 0;

    $sqlBranch = "
        SELECT b.branch_id, b.name AS name, IFNULL(SUM(dt.total), 0) AS total_revenue
        FROM branch b
        LEFT JOIN appointment_transaction a 
            ON b.branch_id = a.branch_id
        LEFT JOIN dental_transaction dt 
            ON dt.appointment_transaction_id = a.appointment_transaction_id
        WHERE YEAR(a.appointment_date) = YEAR(CURDATE())
            AND MONTH(a.appointment_date) = MONTH(CURDATE())
        GROUP BY b.branch_id, b.name
        ORDER BY total_revenue DESC
    ";
    $branchResult = $conn->query($sqlBranch);
    $branches = [];
    while ($row = $branchResult->fetch_assoc()) {
        $branches[] = [
            'branch_id' => $row['branch_id'],
            'name' => $row['name'],
            'total_revenue' => (float)$row['total_revenue']
        ];
    }

    echo json_encode([
        'current_revenue' => (float)$currentRevenue,
        'last_revenue' => (float)$lastRevenue,
        'change_percent' => round($change, 2),
        'branches' => $branches
    ]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
