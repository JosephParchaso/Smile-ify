<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

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
    $branches       = $_POST['branches'] ?? [];

    try {
        $stmt = $conn->prepare("
            INSERT INTO dentist (last_name, first_name, middle_name, gender, date_of_birth, email, contact_number, license_number, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "sssssssss",
            $lastName,
            $firstName,
            $middleName,
            $gender,
            $dateofBirth,
            $email,
            $contactNumber,
            $licenseNumber,
            $status
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
