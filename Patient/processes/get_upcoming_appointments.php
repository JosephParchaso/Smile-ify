<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

$response = ['appointments' => []];

// ✅ Check if logged in and role is patient
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$userId = $_SESSION['user_id'];

try {
    $sql = "
        SELECT 
            a.appointment_date,
            a.appointment_time,
            d.first_name AS dentist_first,
            d.last_name AS dentist_last,
            b.name AS branch_name,
            s.name AS service_name
        FROM appointment_transaction a
        INNER JOIN dentist d ON a.dentist_id = d.dentist_id
        INNER JOIN branch b ON a.branch_id = b.branch_id
        INNER JOIN users u ON a.user_id = u.user_id
        LEFT JOIN service s ON a.service_id = s.service_id
        WHERE a.user_id = ?
            AND u.role = 'patient'
            AND a.appointment_date >= CURDATE()
            AND a.status NOT IN ('Cancelled', 'Completed')
        ORDER BY a.appointment_date ASC, a.appointment_time ASC
        LIMIT 3
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $response['appointments'][] = [
            'date' => date('F j, Y', strtotime($row['appointment_date'])),
            'time' => date('g:i A', strtotime($row['appointment_time'])),
            'dentist' => 'Dr. ' . htmlspecialchars($row['dentist_last']),
            'branch' => htmlspecialchars($row['branch_name']),
            'service' => htmlspecialchars($row['service_name'] ?? 'Not specified')
        ];
    }

    $stmt->close();
    echo json_encode($response);
} catch (Exception $e) {
    echo json_encode([
        'error' => 'Failed to load appointments.',
        'details' => $e->getMessage()
    ]);
}
?>
