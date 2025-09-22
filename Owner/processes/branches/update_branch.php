<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $branch_id     = intval($_POST["branch_id"]);
    $branchName    = trim($_POST["branchName"]);
    $address       = trim($_POST["address"]);
    $phone_number  = trim($_POST["contactNumber"]);
    $opening_time  = !empty($_POST["opening_time"]) ? $_POST["opening_time"] : null;
    $closing_time  = !empty($_POST["closing_time"]) ? $_POST["closing_time"] : null;
    $map_url       = trim($_POST["map_url"] ?? "");
    $status        = $_POST["status"] ?? "Active";

    try {
        $sql = "UPDATE branch 
                    SET name = ?, 
                        address = ?, 
                        phone_number = ?, 
                        opening_time = ?, 
                        closing_time = ?, 
                        status = ?, 
                        map_url = ?, 
                        date_updated = NOW() 
                    WHERE branch_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sssssssi", $branchName, $address, $phone_number, $opening_time, $closing_time, $status, $map_url, $branch_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $_SESSION['updateSuccess'] = "Branch updated successfully!";
            } else {
                $_SESSION['updateError'] = "No changes were made.";
            }
        } else {
            $_SESSION['updateError'] = "Failed to update branch: " . $stmt->error;
        }

        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['updateError'] = "Database error: " . $e->getMessage();
    }

    header("Location: " . BASE_URL . "/Owner/pages/branches.php");
    exit;
} else {
    header("Location: " . BASE_URL . "/index.php");
    exit;
}

$conn->close();