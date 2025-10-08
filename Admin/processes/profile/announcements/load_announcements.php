<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(["data" => []]);
    exit();
}

$sql = "SELECT 
            announcement_id,
            title,
            start_date,
            end_date,
            status
        FROM announcements
        ORDER BY date_created DESC";

$result = $conn->query($sql);

$announcements = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $announcements[] = [
            $row['announcement_id'],
            htmlspecialchars($row['title']),
            $row['start_date'] ?? '-',
            $row['end_date'] ?? '-',
            $row['status'],
            '<button class="btn-announcement" data-type="announcement" data-id="'.$row['announcement_id'].'">Manage</button>'
        ];
    }
}

echo json_encode(["data" => $announcements]);
$conn->close();
