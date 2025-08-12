<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

if (isset($_SESSION['verified_data'])) {
    $verified_data = $_SESSION['verified_data'];
    $email = $verified_data['email'];

    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_created'] = time();

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
    $mail->Subject = "Smile-ify Verification Code Resend";
    $mail->Body = "
        <p>Dear Customer/Patient,</p>
        <p>As requested, here is your OTP:</p>
        <h3>$otp</h3>
        <br>
        <p><i>Smile with confidence.</i></p>
        <p>Best regards,<br><strong>Smile-ify</strong></p>
";

    if (!$mail->send()) {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to resend OTP. Please try again.'
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'message' => 'OTP resent successfully.',
            'otp_created' => $_SESSION['otp_created']
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Session expired. Please re-enter your email.'
    ]);
}
?>
