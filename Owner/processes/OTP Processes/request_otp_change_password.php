<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Not logged in"]);
    exit;
}

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT userName, email FROM users WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "User not found"]);
    exit;
}

$row = $result->fetch_assoc();
$username = $row["userName"];
$email = $row["email"];

$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_created'] = time();
$_SESSION['otp_context'] = 'change_password';

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
$mail->Subject = "Smile-ify Change Password OTP";
$mail->Body = "
    <p>Dear <strong>$username</strong>,</p>
    <p>Your OTP for changing your password is:</p>
    <h3>$otp</h3>
    <br>
    <p><i>Smile with confidence.</i></p>
    <p>Best regards,<br><strong>Smile-ify</strong></p>
";

if (!$mail->send()) {
    $_SESSION['updateError'] = "Failed to send OTP email. Please check your email setup or contact support.";
    header("Location: " . BASE_URL . "/Owner/pages/profile.php");
    exit;
}

header("Location: " . BASE_URL . "/Owner/includes/OTP Includes/otp_verification_change_password.php");
exit;
?>
