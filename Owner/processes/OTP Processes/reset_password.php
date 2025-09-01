<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    $_SESSION['updateError'] = "Unauthorized password change attempt.";
    header("Location: " . BASE_URL . "/Owner/includes/OTP Includes/reset_password.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($newPassword !== $confirmPassword) {
        $_SESSION['updateError'] = "Passwords do not match.";
        header("Location: " . BASE_URL . "/Owner/includes/OTP Includes/reset_password.php");
        exit;
    }

    $userId = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($currentHashedPassword);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($newPassword, $currentHashedPassword)) {
        $_SESSION['updateError'] = "New password cannot be the same as your current password.";
        header("Location: " . BASE_URL . "/Owner/includes/OTP Includes/reset_password.php");
        exit;
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE user_id = ?");
    $stmt->bind_param("si", $hashedPassword, $userId);

    if ($stmt->execute()) {
        $msg = "Your password was changed successfully on " . date("F j, Y, g:i a") . ". If this wasn’t you, please contact support immediately.";
        $notif_sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
        $notif_stmt = $conn->prepare($notif_sql);
        $notif_stmt->bind_param("is", $userId, $msg);
        $notif_stmt->execute();
        $notif_stmt->close();

        unset($_SESSION['otp_verified']);
        $_SESSION['login_success'] = "Password reset successful. You can now login.";
        header("Location: " . BASE_URL . "/index.php");
        exit;
    } else {
        $_SESSION['updateError'] = "Failed to update password. Please try again.";
        header("Location: " . BASE_URL . "/Owner/pages/profile.php");
        exit;
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>