<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? null;
    $status  = $_POST['status'] ?? null;

    if (!$user_id || !$status) {
        $_SESSION['updateError'] = "Missing required fields.";
        header("Location: " . BASE_URL . "/Admin/pages/patients.php");
        exit;
    }

    try {
        $stmt = $conn->prepare("UPDATE users SET status = ?, date_updated = NOW() WHERE user_id = ?");
        $stmt->bind_param("si", $status, $user_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $_SESSION['updateSuccess'] = "Patient set to " . ucfirst($status) . ".";
            } else {
                $_SESSION['updateError'] = "No changes made.";
            }
        } else {
            $_SESSION['updateError'] = "Failed to update status.";
        }

        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['updateError'] = "Database error: " . $e->getMessage();
    }

    $conn->close();

    $redirectTab = ($status === "inactive") ? "inactive" : "registered";

    header("Location: " . BASE_URL . "/Admin/pages/patients.php?tab=" . $redirectTab);
    exit;
} else {
    header("Location: " . BASE_URL . "/index.php");
    exit;
}
