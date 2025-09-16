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
    $user_id        = $_POST['user_id'] ?? null;
    $lastName       = trim($_POST['lastName'] ?? '');
    $firstName      = trim($_POST['firstName'] ?? '');
    $middleName     = trim($_POST['middleName'] ?? '');
    $gender         = $_POST['gender'] ?? '';
    $dateofBirth    = $_POST['dateofBirth'] ?? '';
    $email          = trim($_POST['email'] ?? '');
    $contactNumber  = trim($_POST['contactNumber'] ?? '');
    $address        = trim($_POST['address'] ?? '');
    $branch_id      = $_POST['appointmentBranch'] ?? null;
    $status         = $_POST['status'] ?? 'Inactive';
    $dateStarted    = $_POST['dateStarted'] ?? null;

    if (!empty($email) && !isValidEmailDomain($email)) {
        $_SESSION['updateError'] = "Email domain is not valid or unreachable.";
        header("Location: " . BASE_URL . "/Owner/pages/employees.php");
        exit();
    }

    try {
        $stmt = $conn->prepare("
            UPDATE users 
            SET last_name = ?, 
                first_name = ?, 
                middle_name = ?, 
                gender = ?, 
                date_of_birth = ?, 
                email = ?, 
                contact_number = ?, 
                address = ?, 
                branch_id = ?, 
                status = ?, 
                date_started = ?
            WHERE user_id = ?
        ");

        $stmt->bind_param(
            "ssssssssissi",
            $lastName,
            $firstName,
            $middleName,
            $gender,
            $dateofBirth,
            $email,
            $contactNumber,
            $address,
            $branch_id,
            $status,
            $dateStarted,
            $user_id
        );

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $_SESSION['updateSuccess'] = "Admin updated successfully!";
            }
        } else {
            $_SESSION['updateError'] = "Failed to update dentist.";
        }

        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['updateError'] = "Error: " . $e->getMessage();
    }

    header("Location: " . BASE_URL . "/Owner/pages/employees.php");
    exit();
} else {
    header("Location: " . BASE_URL . "/Owner/pages/employees.php");
    exit();
}
