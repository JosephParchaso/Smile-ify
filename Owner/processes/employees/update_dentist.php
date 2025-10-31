<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

function isValidEmailDomain($email) {
    $domain = substr(strrchr($email, "@"), 1);
    return checkdnsrr($domain, "MX");
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header("Location: " . BASE_URL . "/Owner/pages/employees.php?tab=dentist");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dentistId      = intval($_POST['dentist_id']);
    $lastName       = trim($_POST['lastName']);
    $firstName      = trim($_POST['firstName']);
    $middleName     = trim($_POST['middleName']);
    $gender         = $_POST['gender'];
    $dateofBirth    = $_POST['dateofBirth'] ?? '';
    $email          = trim($_POST['email']);
    $contactNumber  = trim($_POST['contactNumber']);
    $licenseNumber  = trim($_POST['licenseNumber']);
    $dateStarted    = trim($_POST['dateStarted']);
    $status         = $_POST['status'];
    $branches       = isset($_POST['branches']) ? array_map('intval', $_POST['branches']) : [];
    $services       = isset($_POST['services']) ? array_map('intval', $_POST['services']) : [];

    if (!empty($email) && !isValidEmailDomain($email)) {
        $_SESSION['updateError'] = "Email domain is not valid or unreachable.";
        header("Location: " . BASE_URL . "/Owner/pages/employees.php?tab=dentist");
        exit();
    }

    $checkSql = "SELECT last_name, first_name, middle_name, gender, date_of_birth, email, 
                        contact_number, license_number, date_started, status, 
                        signature_image, profile_image
                FROM dentist WHERE dentist_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $dentistId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $current = $result->fetch_assoc();
    $checkStmt->close();

    $changed = false;
    $signatureImage = $current['signature_image'];
    $profileImage = $current['profile_image'];

    $safeLast  = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "_", $lastName));
    $safeFirst = strtolower(preg_replace("/[^a-zA-Z0-9]+/", "_", $firstName));

    if (!empty($_POST['signatureCleared']) && $_POST['signatureCleared'] === "1") {
        if (!empty($current['signature_image'])) {
            $oldPath = $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/images/signatures/' . $current['signature_image'];
            if (file_exists($oldPath)) unlink($oldPath);
        }
        $signatureImage = null;
        $changed = true;
    } elseif (isset($_FILES['signatureImage']) && $_FILES['signatureImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/images/signatures/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        if (!empty($current['signature_image'])) {
            $oldPath = $uploadDir . $current['signature_image'];
            if (file_exists($oldPath)) unlink($oldPath);
        }

        $fileExt = strtolower(pathinfo($_FILES['signatureImage']['name'], PATHINFO_EXTENSION));
        $fileName = "{$safeLast}_{$safeFirst}_signature." . $fileExt;
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['signatureImage']['tmp_name'], $targetPath)) {
            $signatureImage = $fileName;
            $changed = true;
        }
    }

    if (!empty($_POST['profileCleared']) && $_POST['profileCleared'] === "1") {
        if (!empty($current['profile_image'])) {
            $oldPath = $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/images/dentists/' . $current['profile_image'];
            if (file_exists($oldPath)) unlink($oldPath);
        }
        $profileImage = null;
        $changed = true;
    } elseif (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/images/dentists/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        if (!empty($current['profile_image'])) {
            $oldPath = $uploadDir . $current['profile_image'];
            if (file_exists($oldPath)) unlink($oldPath);
        }

        $fileExt = strtolower(pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($fileExt, $allowedExt)) {
            $fileName = "{$safeLast}_{$safeFirst}_profile." . $fileExt;
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $targetPath)) {
                $profileImage = $fileName;
                $changed = true;
            }
        }
    }

    if ($current &&
        ($current['last_name'] !== $lastName ||
        $current['first_name'] !== $firstName ||
        $current['middle_name'] !== $middleName ||
        $current['gender'] !== $gender ||
        $current['date_of_birth'] !== $dateofBirth ||
        $current['email'] !== $email ||
        $current['contact_number'] !== $contactNumber ||
        $current['license_number'] !== $licenseNumber ||
        $current['date_started'] !== $dateStarted ||
        $current['status'] !== $status ||
        $current['signature_image'] !== $signatureImage ||
        $current['profile_image'] !== $profileImage)) {

        $sql = "UPDATE dentist
                SET last_name=?, first_name=?, middle_name=?, gender=?, date_of_birth=?, 
                    email=?, contact_number=?, license_number=?, date_started=?, 
                    status=?, signature_image=?, profile_image=?, date_updated = NOW()
                WHERE dentist_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssssssssssi",
            $lastName, $firstName, $middleName, $gender, $dateofBirth,
            $email, $contactNumber, $licenseNumber, $dateStarted,
            $status, $signatureImage, $profileImage, $dentistId
        );
        $stmt->execute();
        $stmt->close();
        $changed = true;
    }

    $currentBranches = [];
    $res = $conn->prepare("SELECT branch_id FROM dentist_branch WHERE dentist_id = ?");
    $res->bind_param("i", $dentistId);
    $res->execute();
    $result = $res->get_result();
    while ($row = $result->fetch_assoc()) {
        $currentBranches[] = (int)$row['branch_id'];
    }
    $res->close();

    sort($currentBranches);
    sort($branches);

    if ($currentBranches !== $branches) {
        $del = $conn->prepare("DELETE FROM dentist_branch WHERE dentist_id = ?");
        $del->bind_param("i", $dentistId);
        $del->execute();
        $del->close();

        if (!empty($branches)) {
            $insertSql = "INSERT INTO dentist_branch (dentist_id, branch_id) VALUES (?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            foreach ($branches as $branchId) {
                $insertStmt->bind_param("ii", $dentistId, $branchId);
                $insertStmt->execute();
            }
            $insertStmt->close();
        }
        $changed = true;
    }

    $currentServices = [];
    $res = $conn->prepare("SELECT service_id FROM dentist_service WHERE dentist_id = ?");
    $res->bind_param("i", $dentistId);
    $res->execute();
    $result = $res->get_result();
    while ($row = $result->fetch_assoc()) {
        $currentServices[] = (int)$row['service_id'];
    }
    $res->close();

    sort($currentServices);
    sort($services);

    if ($currentServices !== $services) {
        $del = $conn->prepare("DELETE FROM dentist_service WHERE dentist_id = ?");
        $del->bind_param("i", $dentistId);
        $del->execute();
        $del->close();

        if (!empty($services)) {
            $insertSql = "INSERT INTO dentist_service (dentist_id, service_id) VALUES (?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            foreach ($services as $serviceId) {
                $insertStmt->bind_param("ii", $dentistId, $serviceId);
                $insertStmt->execute();
            }
            $insertStmt->close();
        }
        $changed = true;
    }

    if ($changed) {
        $_SESSION['updateSuccess'] = "Dentist updated successfully!";
    }

    $conn->close();
    header("Location: " . BASE_URL . "/Owner/pages/employees.php?tab=dentist");
    exit();
} else {
    header("Location: " . BASE_URL . "/Owner/pages/employees.php?tab=dentist");
    exit();
}
