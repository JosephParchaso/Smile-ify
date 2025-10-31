<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

header('Content-Type: application/json; charset=utf-8');

try {
    $sql = "
        SELECT 
            d.dentist_id,
            d.gender,
            CONCAT(d.first_name, ' ', d.last_name) AS full_name,
            d.email,
            d.contact_number,
            d.profile_image,
            GROUP_CONCAT(DISTINCT b.name ORDER BY b.name SEPARATOR ', ') AS branch_name,
            GROUP_CONCAT(DISTINCT s.name ORDER BY s.name SEPARATOR ', ') AS services
        FROM dentist d
        LEFT JOIN dentist_branch db ON d.dentist_id = db.dentist_id
        LEFT JOIN branch b ON db.branch_id = b.branch_id
        LEFT JOIN dentist_service ds ON d.dentist_id = ds.dentist_id
        LEFT JOIN service s ON ds.service_id = s.service_id
        WHERE d.status = 'Active'
        GROUP BY d.dentist_id
        ORDER BY d.last_name ASC
    ";

    $result = $conn->query($sql);
    $dentists = [];

    while ($row = $result->fetch_assoc()) {
        $prefix = (strtolower($row['gender']) === 'female') ? 'Dra.' : 'Dr.';
        $row['dentist_name'] = $prefix . ' ' . $row['full_name'];

        $row['profile_image'] = !empty($row['profile_image'])
            ? BASE_URL . '/images/dentists/' . $row['profile_image']
            : BASE_URL . '/images/dentists/default_avatar.jpg';

        $row['branch_name'] = $row['branch_name'] ?: 'N/A';
        $row['services'] = $row['services'] ?: 'No assigned services';

        $dentists[] = $row;
    }

    echo json_encode(['success' => true, 'dentists' => $dentists]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
