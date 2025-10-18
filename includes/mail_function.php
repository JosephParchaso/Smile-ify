<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/Mail/phpmailer/PHPMailerAutoload.php';

/**
 * sendMail
 * Reusable function to send HTML emails using PHPMailer
 *
 * @param string $to       Recipient email address
 * @param string $subject  Email subject line
 * @param string $body     HTML email content
 * @param string $fromName Optional display name (default: Smile-ify Notifications)
 * @return bool            True on success, false on failure
 */
function sendMail($to, $subject, $body, $fromName = 'Smile-ify Notifications')
{
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';

    $mail->Username = 'smileify.web@gmail.com';
    $mail->Password = '';

    $mail->setFrom('smileify.web@gmail.com', $fromName);
    $mail->addAddress($to);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;

    if (!$mail->send()) {
        error_log('[' . date('Y-m-d H:i:s') . '] Mail Error to ' . $to . ': ' . $mail->ErrorInfo . PHP_EOL, 3, BASE_PATH . '/Mail/phpmailer/mail_error.log');
        return false;
    } else {
        error_log('[' . date('Y-m-d H:i:s') . '] Mail Sent to ' . $to . ' | Subject: ' . $subject . PHP_EOL, 3, BASE_PATH . '/Mail/phpmailer/mail_success.log');
    }

    return true;
}
?>
