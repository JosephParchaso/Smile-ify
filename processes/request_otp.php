<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['verified_data'] = $_POST;

    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_created'] = time();
    $_SESSION['mail'] = $_POST["email"];

    require BASE_PATH . '/Mail/phpmailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';

    $mail->Username = 'theartp2@gmail.com';
    $mail->Password = 'xnlc pyjn okdg ihwd';

    $mail->setFrom('theartp2@gmail.com', 'Smile-ify OTP Verification');
    $mail->addAddress($_POST["email"]);

    $mail->isHTML(true);
    $mail->Subject = "Smile-ify Verification Code";
    $mail->Body = "
        <p>Dear Customer/Patient,</p>
        <p>Your One-Time Password (OTP) is:</p>
        <h3>$otp</h3>
        <br>
        <p><i>Smile with confidence.</i></p>
        <p>Best regards,<br><strong>Smile-ify</strong></p>
    ";

    if (!$mail->send()) {
        $_SESSION['otp_error'] = "Invalid email address. Please try again.";
        header("Location: " . BASE_URL . "/includes/otp_verification.php");
        exit;
    }

    header("Location: " . BASE_URL . "/includes/otp_verification.php");
    exit;
}
?>
