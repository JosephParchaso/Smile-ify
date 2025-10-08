<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json; charset=utf-8');

$response = ['announcements' => []];

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

try {
    $sql = "
        SELECT 
            title, 
            description, 
            start_date, 
            end_date
        FROM announcements
        WHERE status = 'Active'
            AND (end_date IS NULL OR end_date >= CURDATE())
            ORDER BY start_date ASC, date_created DESC
            LIMIT 3
    ";

    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $response['announcements'][] = [
            'title' => htmlspecialchars($row['title']),
            'description' => htmlspecialchars($row['description']),
            'start_date' => $row['start_date'] ? date('F j, Y', strtotime($row['start_date'])) : '',
            'end_date' => $row['end_date'] ? date('F j, Y', strtotime($row['end_date'])) : ''
        ];
    }

    echo json_encode($response);
} catch (Exception $e) {
    echo json_encode([
        'error' => 'Failed to load announcements.',
        'details' => $e->getMessage()
    ]);
}

$conn->close();
