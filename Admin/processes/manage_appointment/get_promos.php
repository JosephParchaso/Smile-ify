<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

$promos = [];

if (isset($_GET['appointment_id'])) {
    $appointmentId = intval($_GET['appointment_id']);

    $stmt = $conn->prepare("
        SELECT branch_id 
        FROM appointment_transaction 
        WHERE appointment_transaction_id = ?
        LIMIT 1
    ");
    $stmt->bind_param("i", $appointmentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if ($row) {
        $branchId = intval($row['branch_id']);

        $stmt = $conn->prepare("
            SELECT 
                p.promo_id AS id,
                p.name,
                p.description,
                p.discount_type,
                p.discount_value
            FROM branch_promo bp
            INNER JOIN promo p ON bp.promo_id = p.promo_id
            WHERE bp.branch_id = ?
                AND bp.status = 'Active'
            ORDER BY p.name ASC
        ");
        $stmt->bind_param("i", $branchId);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($promo = $result->fetch_assoc()) {
            $promos[] = $promo;
        }

        $stmt->close();
    }
}

echo json_encode($promos);

$conn->close();
