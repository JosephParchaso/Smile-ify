<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT userName, email FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'User not found.']);
        exit;
    }

    $row = $result->fetch_assoc();
    $username = $row['userName'];
    $email = $row['email'];
    $context = "change_password";

} elseif (isset($_SESSION['verified_data'])) {
    $verified_data = $_SESSION['verified_data'];
    $email = $verified_data['email'];
    $username = $verified_data['username'] ?? "Customer/Patient";
    $context = "forgot_or_register";

} else {
    echo json_encode(['success' => false, 'message' => 'Session expired. Please log in or re-enter your email.']);
    exit;
}

$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_created'] = time();
$_SESSION['otp_context'] = $context;

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
$mail->Subject = "Smile-ify OTP Resend";
$mail->Body = "
    <p>Dear <strong>$username</strong>,</p>
    <p>Here is your OTP code:</p>
    <h3>$otp</h3>
    <p>Context: <i>$context</i></p>
    <br>
    <p><i>Smile with confidence.</i></p>
    <p>Best regards,<br><strong>Smile-ify</strong></p>
";

if (!$mail->send()) {
    echo json_encode(['success' => false, 'message' => 'Failed to resend OTP. Please try again.']);
} else {
    echo json_encode([
        'success' => true,
        'message' => 'OTP resent successfully.',
        'otp_created' => $_SESSION['otp_created'],
        'context' => $context
    ]);
}
