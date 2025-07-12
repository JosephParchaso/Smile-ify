<?php
session_start();
require 'connection.php';

if (isset($_SESSION['verified_data'])) {
    $verified_data = $_SESSION['verified_data'];
    $email = $verified_data['email']; // Assuming 'email' is a key in the verified_data array

    // Generate a new OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;

    // Send the OTP via email
    require '../Mail/phpmailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';

    $mail->Username = 'theartp2@gmail.com'; // Your Gmail username
    $mail->Password = 'xnlc pyjn okdg ihwd'; // Your Gmail password

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
        // Email sending failed
        echo json_encode(['success' => false, 'message' => 'Failed to resend OTP. Please try again.']);
    } else {
        // Email sent successfully
        echo json_encode(['success' => true, 'message' => 'OTP resent successfully.']);
    }
} else {
    // Session variable not set
    echo json_encode(['success' => false, 'message' => 'Session variable not set.']);
}
?>
