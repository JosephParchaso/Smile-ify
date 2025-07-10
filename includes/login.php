<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userName'], $_POST['passWord'])) {
    $username = trim($_POST['userName']);
    $password = trim($_POST['passWord']);

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // Store user info in session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Redirect based on role
                if (str_starts_with($user['username'], 'owner')) {
                    header("Location: ../Owner/index.php");
                    exit;
                } elseif (str_starts_with($user['username'], 'admin')) {
                    header("Location: ../Admin/index.php");
                    exit;
                } elseif (str_starts_with($user['username'], 'patient')) {
                    header("Location: ../Patient/index.php");
                    exit;
                } else {
                    $_SESSION['login_error'] = "Unknown role.";
                    header("Location: ../index.php");
                    exit;
                }
            } else {
                $_SESSION['login_error'] = "Invalid username or password.";
                header("Location: ../index.php");
                exit;
            }
        } else {
            $_SESSION['login_error'] = "Invalid username or password.";
            header("Location: ../index.php");
            exit;
        }
        $stmt->close();
    }
} else {
    header("Location: ../index.php");
    exit;
}
?>
