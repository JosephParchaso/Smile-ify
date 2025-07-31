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

    $mail->setFrom('theartp2@gmail.com', 'OTP Verification');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Resend verify code";
    $mail->Body = "<p>Dear customer/patient, </p> <h3>Your OTP code is $otp <br></h3>
        <br><br>
        <p><i> Smile with confidence. </i></p>
        <p>Best Regards,</p>
        <b>Smile-ify</b>";

    if (!$mail->send()) {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to resend OTP. Please try again.'
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'message' => 'OTP resent successfully.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Session expired. Please re-enter your email.'
    ]);
}
?>
