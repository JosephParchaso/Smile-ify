<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        $_SESSION['updateError'] = "User not logged in.";
        header("Location: " . BASE_URL . "/index.php");
        exit;
    }

    $contact = trim($_POST['contactNumber'] ?? '');
    $address = trim($_POST['address'] ?? '');

    try {
        $stmt = $conn->prepare("
            UPDATE users 
            SET contact_number = ?, address = ?, date_updated = NOW() 
            WHERE user_id = ? 
                AND (contact_number <> ? OR address <> ?)
        ");
        $stmt->bind_param("ssiss", $contact, $address, $user_id, $contact, $address);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $_SESSION['updateSuccess'] = "Profile updated successfully!";
            }
        } else {
            $_SESSION['updateError'] = "Failed to update profile. Please try again.";
        }
        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['updateError'] = "Database error: " . $e->getMessage();
    }

    header("Location: " . BASE_URL . "/Owner/pages/profile.php");
    exit;
} else {
    header("Location: " . BASE_URL . "/index.php");
    exit;
}

$conn->close();
