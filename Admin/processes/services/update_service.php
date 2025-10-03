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
    $name       = trim($_POST["serviceName"]);
    $price      = floatval($_POST["price"]);
    $status     = trim($_POST["status"]);

    try {
        $checkSql = "SELECT s.name, s.price, bs.status
                        FROM service s
                        JOIN branch_service bs ON s.service_id = bs.service_id
                        WHERE s.service_id = ? AND bs.branch_id = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("ii", $service_id, $branch_id);
        $checkStmt->execute();
        $current = $checkStmt->get_result()->fetch_assoc();
        $checkStmt->close();

        if (!$current) {
            $_SESSION['updateError'] = "Service not found.";
            header("Location: " . BASE_URL . "/Admin/pages/services.php");
            exit;
        }

        if (
            $current['name'] === $name &&
            floatval($current['price']) === $price &&
            $current['status'] === $status
        ) {
            $_SESSION['updateInfo'] = "No changes were made.";
        } else {
            if ($current['name'] !== $name || floatval($current['price']) !== $price) {
                $sql = "UPDATE service 
                        SET name = ?, price = ?
                        WHERE service_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sdi", $name, $price, $service_id);
                $stmt->execute();
                $stmt->close();
            }
            $sql2 = "UPDATE branch_service 
                    SET status = ?, date_updated = NOW()
                    WHERE branch_id = ? AND service_id = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("sii", $status, $branch_id, $service_id);
            $stmt2->execute();
            $stmt2->close();

            $_SESSION['updateSuccess'] = "Service updated successfully!";
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
