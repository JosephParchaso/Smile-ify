<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $branch_id = $_SESSION['branch_id'] ?? null;

    if (!$branch_id) {
        $_SESSION['updateError'] = "Branch not set. Please log in again.";
        header("Location: " . BASE_URL . "/index.php");
        exit;
    }

    $name     = trim($_POST["serviceName"]);
    $price    = floatval($_POST["price"]);
    $status   = trim($_POST["status"]);
    $duration = intval($_POST["duration_minutes"]);

    try {
        $sql = "INSERT INTO service (name, price, duration_minutes) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("sdi", $name, $price, $duration);

        if ($stmt->execute()) {
            $service_id = $stmt->insert_id;
            $stmt->close();

            $sql2 = "INSERT INTO branch_service 
                    (branch_id, service_id, status, date_created, date_updated) 
                    VALUES (?, ?, ?, NOW(), NOW())";
            $stmt2 = $conn->prepare($sql2);
            if (!$stmt2) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            $stmt2->bind_param("iis", $branch_id, $service_id, $status);
            $stmt2->execute();
            $stmt2->close();

            $_SESSION['updateSuccess'] = "Service added successfully!";
        } else {
            $_SESSION['updateError'] = "Failed to add service: " . $stmt->error;
            $stmt->close();
        }
    } catch (Exception $e) {
        $_SESSION['updateError'] = "Database error: " . $e->getMessage();
    }

    header("Location: " . BASE_URL . "/Admin/pages/services.php");
    exit;
} else {
    header("Location: " . BASE_URL . "/index.php");
    exit;
}

$conn->close();
