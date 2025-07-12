<?php
session_start();
require '../includes/db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['verified_data'] = $_POST;

    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_created'] = time();
    $_SESSION['mail'] = $_POST["email"];

    require '../Mail/phpmailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';

    $mail->Username = 'theartp2@gmail.com';
    $mail->Password = 'xnlc pyjn okdg ihwd';

    $mail->setFrom('theartp2@gmail.com', 'OTP Verification');
    $mail->addAddress($_POST["email"]);

    $mail->isHTML(true);
    $mail->Subject = "Your verify code";
    $mail->Body = "<p>Dear customer/patient, </p> <h3>Your OTP code is $otp <br></h3>
        <br><br>
        <p><i> Smile with confidence. </i></p>
        <p>Best Regards,</p>
        <b>Smile-ify</b>";

    if (!$mail->send()) {
        $_SESSION['otp_error'] = "Invalid email address. Please try again.";
        header("Location: ../includes/otp_verification.php");
    }

    header("Location: ../includes/otp_verification.php");
    exit;
}
