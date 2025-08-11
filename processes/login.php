<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userName'], $_POST['passWord'])) {
    $username = trim($_POST['userName']);
    $password = trim($_POST['passWord']);

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT u.*, b.name AS branch_name, 
                                            b.branch_id AS branch_id
                                FROM users u
                                LEFT JOIN branch b ON u.branch_id = b.branch_id
                                WHERE u.username = ?"
                                );
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (strtolower($user['status']) !== 'active') {
                $_SESSION['login_error'] = "Account is inactive. Please contact support.";
                header("Location: " . BASE_URL . "/index.php");
                exit;
            }

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['branch_id'] = $user['branch_id'];
                $_SESSION['branch_name'] = $user['branch_name'];

                $role = strtolower($user['role']);

                switch ($role) {
                    case 'owner':
                        header("Location: " . BASE_URL . "/Owner/index.php");
                        break;
                    case 'admin':
                        header("Location: " . BASE_URL . "/Admin/index.php");
                        break;
                    case 'patient':
                        header("Location: " . BASE_URL . "/Patient/index.php");
                        break;
                    default:
                        header("Location: " . BASE_URL . "/index.php");
                        break;
                }
                exit;
            } else {
                $_SESSION['login_error'] = "Invalid username or password.";
                header("Location: " . BASE_URL . "/index.php");
                exit;
            }
        } else {
            $_SESSION['login_error'] = "Invalid username or password.";
            header("Location: " . BASE_URL . "/index.php");
            exit;
        }
        $stmt->close();
    }
} else {
    header("Location: " . BASE_URL . "/index.php");
    exit;
}
?>
