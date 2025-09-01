<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    try {
        $branch_name = '';
        if ($branch_id) {
            $stmtBranch = $conn->prepare("SELECT name FROM branch WHERE branch_id = ?");
            $stmtBranch->bind_param("i", $branch_id);
            $stmtBranch->execute();
            $stmtBranch->bind_result($branch_name);
            $stmtBranch->fetch();
            $stmtBranch->close();
        }

        $username = generateUniqueUsername($lastName, $firstName, $conn);

        $s = $lastName . '_' . $firstName;
        $password = password_hash($raw_password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("
            INSERT INTO users (
                username, last_name, first_name, middle_name, gender, date_of_birth,
                email, contact_number, address, branch_id, role, status, password, date_started
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'admin', ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssssssssissss",
            $username,
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
            $password,
            $dateStarted
        );

        if ($stmt->execute()) {
            $_SESSION['updateSuccess'] = "Admin added successfully! Username: {$username}, Default password: {$raw_password}";
        } else {
            $_SESSION['updateError'] = "Failed to insert admin.";
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

function generateUniqueUsername($lastName, $firstName, $conn) {
    $username_base = $lastName . '_' . strtoupper(substr($firstName, 0, 1));
    $username = $username_base;
    $counter = 0;

    $check_sql = "SELECT username FROM users WHERE username = ?";
    $check_stmt = $conn->prepare($check_sql);

    do {
        if ($counter > 0) {
            $username = $username_base . $counter;
        }

        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_stmt->store_result();
        $counter++;
    } while ($check_stmt->num_rows > 0);

    return $username;
}
