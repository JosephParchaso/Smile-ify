<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "No dentist ID provided"]);
    exit();
}

$dentistId = intval($_GET['id']);

$sql = "SELECT 
            dentist_id,
            last_name,
            middle_name,
            first_name,
            gender,
            date_of_birth,
            email,
            contact_number,
            license_number,
            status,
            signature_image,
            profile_image,
            date_started,
            date_updated,
            date_created
        FROM dentist
        WHERE dentist_id = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $dentistId);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $branchSql = "SELECT branch_id FROM dentist_branch WHERE dentist_id = ?";
    $branchStmt = $conn->prepare($branchSql);
    $branchStmt->bind_param("i", $dentistId);
    $branchStmt->execute();
    $branchResult = $branchStmt->get_result();

    $branches = [];
    while ($branchRow = $branchResult->fetch_assoc()) {
        $branches[] = (int)$branchRow['branch_id'];
    }
    $row['branches'] = $branches;

    $serviceSql = "SELECT service_id FROM dentist_service WHERE dentist_id = ?";
    $serviceStmt = $conn->prepare($serviceSql);
    $serviceStmt->bind_param("i", $dentistId);
    $serviceStmt->execute();
    $serviceResult = $serviceStmt->get_result();

    $services = [];
    while ($serviceRow = $serviceResult->fetch_assoc()) {
        $services[] = (int)$serviceRow['service_id'];
    }
    $row['services'] = $services;

    echo json_encode($row);
} else {
    echo json_encode(["error" => "Dentist not found"]);
}

$conn->close();
