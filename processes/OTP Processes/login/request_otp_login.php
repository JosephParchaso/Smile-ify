<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';
require BASE_PATH . '/Mail/phpmailer/PHPMailerAutoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userName'], $_POST['passWord'])) {
    $username = trim($_POST['userName']);
    $password = trim($_POST['passWord']);

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("
            SELECT u.*, b.name AS branch_name, b.branch_id AS branch_id 
            FROM users u
            LEFT JOIN branch b ON u.branch_id = b.branch_id
            WHERE u.username = ?
        ");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (strtolower($user['status']) !== 'active') {
                $_SESSION['login_error'] = "Account is inactive. Please contact the clinic.";
                header("Location: " . BASE_URL . "/index.php");
                exit;
            }

            if (password_verify($password, $user['password'])) {
                $otp = rand(100000, 999999);
                $_SESSION['pending_login_user'] = $user;
                $_SESSION['otp'] = $otp;
                $_SESSION['otp_created'] = time();

                $email = $user['email'];

                if (empty($email)) {
                    $_SESSION['otp_error'] = "No email found for this user.";
                    header("Location: " . BASE_URL . "/index.php");
                    exit;
                }

                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';
                $mail->Username = 'smileify.web@gmail.com';
                $mail->Password = '';
                $mail->setFrom('smileify.web@gmail.com', 'Smile-ify Login Verification');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = "Smile-ify Login OTP";
                $mail->Body = "
                    <p>Dear {$user['username']},</p>
                    <p>Your One-Time Password (OTP) for login is:</p>
                    <h3>$otp</h3>
                    <p>This code will expire in 5 minutes.</p>
                    <p>Smile with confidence,<br><strong>Smile-ify</strong></p>
                ";

                if (!$mail->send()) {
                    $_SESSION['otp_error'] = "Failed to send OTP. Please try again.";
                    header("Location: " . BASE_URL . "/index.php");
                    exit;
                }

                header("Location: " . BASE_URL . "/includes/OTP Includes/login/otp_verification_login.php");
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
    }
} else {
    header("Location: " . BASE_URL . "/index.php");
    exit;
}
?>
