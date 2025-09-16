<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

function isValidEmailDomain($email) {
    $domain = substr(strrchr($email, "@"), 1);
    return checkdnsrr($domain, "MX");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['verified_data'] = $_POST;
    $email = trim($_POST["email"]);

    if (!isValidEmailDomain($email)) {
        $_SESSION['otp_error'] = "Email domain is not valid or unreachable.";
        header("Location: " . BASE_URL . "/index.php");
        exit();
    }

    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_created'] = time();
    $_SESSION['mail'] = $email;

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
    $mail->addAddress($email);

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
        header("Location: " . BASE_URL . "/includes/OTP Includes/otp_verification.php");
        exit;
    }

    header("Location: " . BASE_URL . "/includes/OTP Includes/otp_verification.php");
    exit;
}
?>
