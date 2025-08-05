<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    header("Location: " . BASE_URL . "/index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $_SESSION['otp_error'] = "Passwords do not match.";
        header("Location: " . BASE_URL . "/includes/reset_password_form.php");
        exit;
    }

    if (!isset($_SESSION['reset_username'])) {
        $_SESSION['otp_error'] = "Session error. Please try again.";
        header("Location: " . BASE_URL . "/index.php");
        exit;
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $username = $_SESSION['reset_username'];

    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE userName = ?");
    $stmt->bind_param("ss", $hashedPassword, $username);

    if ($stmt->execute()) {
        session_unset();
        $_SESSION['login_success'] = "Password reset successful. You can now login.";
        header("Location: " . BASE_URL . "/index.php");
        exit;
    } else {
        $_SESSION['otp_error'] = "Failed to reset password.";
        header("Location: " . BASE_URL . "/includes/reset_password_form.php");
        exit;
    }
}
?>
