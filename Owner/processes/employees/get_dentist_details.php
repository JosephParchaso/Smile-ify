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
            date_of_birth_iv,
            date_of_birth_tag,
            email,
            contact_number,
            contact_number_iv,
            contact_number_tag,
            license_number,
            license_number_iv,
            license_number_tag,
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
    if (!empty($row['date_of_birth']) && !empty($row['date_of_birth_iv']) && !empty($row['date_of_birth_tag'])) {
        $row['date_of_birth'] = decryptField($row['date_of_birth'], $row['date_of_birth_iv'], $row['date_of_birth_tag'], $ENCRYPTION_KEY);
    }

    if (!empty($row['contact_number']) && !empty($row['contact_number_iv']) && !empty($row['contact_number_tag'])) {
        $row['contact_number'] = decryptField($row['contact_number'], $row['contact_number_iv'], $row['contact_number_tag'], $ENCRYPTION_KEY);
    }

    if (!empty($row['license_number']) && !empty($row['license_number_iv']) && !empty($row['license_number_tag'])) {
        $row['license_number'] = decryptField($row['license_number'], $row['license_number_iv'], $row['license_number_tag'], $ENCRYPTION_KEY);
    }

    unset(
        $row['date_of_birth_iv'], $row['date_of_birth_tag'],
        $row['contact_number_iv'], $row['contact_number_tag'],
        $row['license_number_iv'], $row['license_number_tag']
    );

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
    $branchStmt->close();

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
    $serviceStmt->close();

    echo json_encode($row);
} else {
    echo json_encode(["error" => "Dentist not found"]);
}

$conn->close();
?>
