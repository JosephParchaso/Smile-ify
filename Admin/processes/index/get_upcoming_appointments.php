<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

$response = [
    'today' => 0,
    'tomorrow' => 0
];

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

if (!isset($_SESSION['branch_id'])) {
    echo json_encode(['error' => 'Branch not set in session']);
    exit;
}

$branchId = $_SESSION['branch_id'];

try {
    $today = date('Y-m-d');
    $tomorrow = date('Y-m-d', strtotime('+1 day'));

    $sqlToday = "SELECT COUNT(*) AS count 
                    FROM appointment_transaction 
                    WHERE DATE(appointment_date) = ? 
                    AND branch_id = ?";
    $stmt = $conn->prepare($sqlToday);
    $stmt->bind_param("si", $today, $branchId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $response['today'] = $result['count'] ?? 0;

    $sqlTomorrow = "SELECT COUNT(*) AS count 
                    FROM appointment_transaction 
                    WHERE DATE(appointment_date) = ? 
                    AND branch_id = ?";
    $stmt = $conn->prepare($sqlTomorrow);
    $stmt->bind_param("si", $tomorrow, $branchId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $response['tomorrow'] = $result['count'] ?? 0;

    $stmt->close();

    echo json_encode($response);
} catch (Exception $e) {
    echo json_encode([
        'error' => 'Failed to fetch data.',
        'details' => $e->getMessage()
    ]);
}
?>
