<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/db.php';
$baseUrl = $_SERVER['HTTP_HOST'] === 'localhost' ? '/Smile-ify' : '';

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
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                $role = strtolower($user['role']);

                switch ($role) {
                    case 'owner':
                        header("Location: $baseUrl/Owner/index.php");
                        break;
                    case 'admin':
                        header("Location: $baseUrl/Admin/index.php");
                        break;
                    case 'patient':
                        header("Location: $baseUrl/Patient/index.php");
                        break;
                    default:
                        header("Location: $baseUrl/index.php");
                        break;
                }
                exit;
            } else {
                $_SESSION['login_error'] = "Invalid username or password.";
                header("Location: $baseUrl/index.php");
                exit;
            }
        } else {
            $_SESSION['login_error'] = "Invalid username or password.";
            header("Location: $baseUrl/index.php");
            exit;
        }
        $stmt->close();
    }
} else {
    header("Location: $baseUrl/index.php");
    exit;
}
?>
