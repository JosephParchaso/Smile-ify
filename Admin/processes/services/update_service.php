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

    $service_id = intval($_POST["service_id"]);
    $name   = trim($_POST["serviceName"]);
    $price  = floatval($_POST["price"]);
    $status = trim($_POST["status"]);

    try {
        $sql = "UPDATE service 
                SET name = ?, price = ? 
                WHERE service_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed (service): " . $conn->error);
        }
        $stmt->bind_param("sdi", $name, $price, $service_id);
        $stmt->execute();
        $affected1 = $stmt->affected_rows;
        $stmt->close();

        $sql2 = "UPDATE branch_service 
                    SET status = ?, 
                        date_updated = CASE 
                        WHEN status <> ? THEN NOW() 
                        ELSE date_updated 
                        END
                    WHERE branch_id = ? AND service_id = ?";
        $stmt2 = $conn->prepare($sql2);
        if (!$stmt2) {
            throw new Exception("Prepare failed (branch_service): " . $conn->error);
        }
        $stmt2->bind_param("ssii", $status, $status, $branch_id, $service_id);
        $stmt2->execute();
        $affected2 = $stmt2->affected_rows;
        $stmt2->close();

        if ($affected1 > 0 || $affected2 > 0) {
            $_SESSION['updateSuccess'] = "Service updated successfully!";
        } else {
            $_SESSION['updateInfo'] = "No changes were made.";
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
