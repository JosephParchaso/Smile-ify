<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);

    $stmt = $conn->prepare("SELECT email, status FROM users WHERE userName = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['username_error'] = "Username not found.";
        $_SESSION['show_forgot_modal'] = true;
        header("Location: " . BASE_URL . "/index.php");
        exit;
    }

    $row = $result->fetch_assoc();
    $email = $row["email"];
    $status = $row["status"];

    if (strtolower($status) !== "active") {
        $_SESSION['username_error'] = "Account is inactive. Please contact support.";
        $_SESSION['show_forgot_modal'] = true;
        header("Location: " . BASE_URL . "/index.php");
        exit;
    }

    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_created'] = time();

    $_SESSION['verified_data'] = [
        'username' => $username,
        'email' => $email,
        'context' => 'password_reset'
    ];

    require BASE_PATH . '/Mail/phpmailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';

    $mail->Username = 'theartp2@gmail.com';
    $mail->Password = 'xnlcpyjnokdgihwd';

    $mail->setFrom('theartp2@gmail.com', 'Smile-ify OTP Verification');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Smile-ify Password Reset Verification Code";
    $mail->Body = "
        <p>Dear <strong>$username</strong>,</p>
        <p>Your password reset OTP is:</p>
        <h3>$otp</h3>
        <br>
        <p><i>Smile with confidence.</i></p>
        <p>Best regards,<br><strong>Smile-ify</strong></p>
    ";

    if (!$mail->send()) {
        $_SESSION['otp_error'] = "Failed to send OTP email. Please try again.";
        header("Location: " . BASE_URL . "/index.php");
        exit;
    }

    header("Location: " . BASE_URL . "/includes/OTP Includes/otp_verification_forgot_password.php");
    exit;
}
?>
