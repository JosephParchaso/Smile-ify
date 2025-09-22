<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

function isValidEmailDomain($email) {
    $domain = substr(strrchr($email, "@"), 1);
    return checkdnsrr($domain, "MX");
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lastName       = trim($_POST['lastName']);
    $firstName      = trim($_POST['firstName']);
    $middleName     = trim($_POST['middleName']);
    $gender         = $_POST['gender'];
    $dateofBirth    = $_POST['dateofBirth'] ?? '';
    $email          = trim($_POST['email']);
    $contactNumber  = trim($_POST['contactNumber']);
    $licenseNumber  = trim($_POST['licenseNumber']);
    $status         = $_POST['status'];
    $dateStarted    = $_POST['dateStarted'] ?? null;
    $branches       = $_POST['branches'] ?? [];
    $services       = $_POST['services'] ?? [];

    if (!empty($email) && !isValidEmailDomain($email)) {
        $_SESSION['updateError'] = "Email domain is not valid or unreachable.";
        header("Location: " . BASE_URL . "/Owner/pages/employees.php?tab=dentist");
        exit();
    }

    $signatureImage = null;
    if (isset($_FILES['signatureImage']) && $_FILES['signatureImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/images/signatures/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = uniqid() . "_" . basename($_FILES['signatureImage']['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['signatureImage']['tmp_name'], $targetPath)) {
            $signatureImage = $fileName;
        }
    }

    try {
        $stmt = $conn->prepare("
            INSERT INTO dentist 
                (last_name, first_name, middle_name, gender, date_of_birth, email, contact_number, license_number, date_started, status, signature_image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "sssssssssss",
            $lastName,
            $firstName,
            $middleName,
            $gender,
            $dateofBirth,
            $email,
            $contactNumber,
            $licenseNumber,
            $dateStarted,
            $status,
            $signatureImage
        );

        if ($stmt->execute()) {
            $dentistId = $stmt->insert_id;

            if (!empty($branches)) {
                $stmt2 = $conn->prepare("INSERT INTO dentist_branch (dentist_id, branch_id) VALUES (?, ?)");
                foreach ($branches as $branchId) {
                    $stmt2->bind_param("ii", $dentistId, $branchId);
                    $stmt2->execute();
                }
                $stmt2->close();
            }

            if (!empty($services)) {
                $stmt3 = $conn->prepare("INSERT INTO dentist_service (dentist_id, service_id) VALUES (?, ?)");
                foreach ($services as $serviceId) {
                    $stmt3->bind_param("ii", $dentistId, $serviceId);
                    $stmt3->execute();
                }
                $stmt3->close();
            }

            $_SESSION['updateSuccess'] = "Dentist added successfully!";
        } else {
            $_SESSION['updateError'] = "Failed to add dentist.";
        }

        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['updateError'] = "Error: " . $e->getMessage();
    }

    header("Location: " . BASE_URL . "/Owner/pages/employees.php?tab=dentist");
    exit();
} else {
    header("Location: " . BASE_URL . "/Owner/pages/employees.php?tab=dentist");
    exit();
}
