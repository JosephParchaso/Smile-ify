<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header("Location: " . BASE_URL . "/Owner/pages/employees.php");
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
    $status         = $_POST['status'];
    $branches       = isset($_POST['branches']) ? array_map('intval', $_POST['branches']) : [];

    $sql = "UPDATE dentist
            SET last_name = ?, 
                first_name = ?, 
                middle_name = ?, 
                gender = ?, 
                date_of_birth = ?,
                email = ?, 
                contact_number = ?, 
                license_number = ?, status = ?
            WHERE dentist_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssi",
        $lastName,
        $firstName,
        $middleName,
        $gender,
        $dateofBirth,
        $email,
        $contactNumber,
        $licenseNumber,
        $status,
        $dentistId
    );

    $changed = false;

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
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
            $deleteSql = "DELETE FROM dentist_branch WHERE dentist_id = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("i", $dentistId);
            $deleteStmt->execute();
            $deleteStmt->close();

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

        if ($changed) {
            $_SESSION['updateSuccess'] = "Dentist updated successfully!";
        }
    } else {
        $_SESSION['updateError'] = "Failed to update dentist.";
    }

    $stmt->close();
    $conn->close();

    header("Location: " . BASE_URL . "/Owner/pages/employees.php?tab=dentist");
    exit();
} else {
    header("Location: " . BASE_URL . "/Owner/pages/employees.php?tab=dentist");
    exit();
}
