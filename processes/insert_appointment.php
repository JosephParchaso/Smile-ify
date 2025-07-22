<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["verify"])) {
    $otp = $_SESSION['otp'] ?? null;
    $otp_code = trim($_POST['otpCode']);
    $otp_created = $_SESSION['otp_created'] ?? 0;
    $expiry_limit = 60;
    $email = $_SESSION['mail'] ?? null;

    // If OTP has expired
    if (time() - $otp_created > $expiry_limit) {
        $_SESSION['otp_error'] = "OTP has expired. Please request a new one.";
        header("Location: /Smile-ify/includes/otp_verification.php");
        exit;
    }

    // If OTP is incorrect
    if ((string)$otp !== (string)$otp_code) {
        $_SESSION['otp_error'] = "Invalid OTP code.";
        header("Location: /Smile-ify/includes/otp_verification.php");
        exit;
}
    else if (isset($_SESSION['verified_data'])) {
        $lastName = $_SESSION['verified_data']['lastName'];
        $firstName = $_SESSION['verified_data']['firstName'];
        $middleName = $_SESSION['verified_data']['middleName'];
        $email = $_SESSION['verified_data']['email'];
        $gender = $_SESSION['verified_data']['gender'];
        $contactNumber = $_SESSION['verified_data']['contactNumber'];
        $role = 'patient'; 

        $appointmentBranch = $_SESSION['verified_data']['appointmentBranch'];
        $appointmentService = $_SESSION['verified_data']['appointmentService'];
        $appointmentDentist = $_SESSION['verified_data']['appointmentDentist'];
        $appointmentDate = $_SESSION['verified_data']['appointmentDate'];
        $appointmentTime = $_SESSION['verified_data']['appointmentTime'];

        $username = generateUniqueUsername($lastName, $firstName, $middleName, $conn);
        $default_password = "passworduser";
        $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);

        $conn->begin_transaction();

        $user_sql = "INSERT INTO users (username, password, last_name, middle_name, first_name, gender, email, contact_number, role)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $user_stmt = $conn->prepare($user_sql);
        $user_stmt->bind_param("sssssssss", $username, $hashed_password, $lastName, $middleName, $firstName, $gender, $email, $contactNumber, $role);

        if ($user_stmt->execute()) {
        }

        $user_id = $user_stmt->insert_id;

        if ($appointmentDentist == "none") {
            $appointmentDentist = null;
        }

        $appointment_sql = "INSERT INTO appointment_transaction (user_id, branch_id, service_id, dentist_id, appointment_date, appointment_time)
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $appointment_stmt = $conn->prepare($appointment_sql);
        $appointment_stmt->bind_param("iiisss", $user_id, $appointmentBranch, $appointmentService, $appointmentDentist, $appointmentDate, $appointmentTime);
    }
    
    if (!$appointment_stmt->execute()) {
        throw new Exception("Appointment insert failed: " . $appointment_stmt->error);
    }

    $welcome_sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
    $welcome_stmt = $conn->prepare($welcome_sql);
    $welcome_msg = "Welcome to Smile-ify! Your account was successfully created.";
    $welcome_stmt->bind_param("is", $user_id, $welcome_msg);
    $welcome_stmt->execute();

    $notif_sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
    $notif_stmt = $conn->prepare($notif_sql);
    $msg = "Your appointment on $appointmentDate at $appointmentTime was successfully booked!";
    $notif_stmt->bind_param("is", $user_id, $msg);
    $notif_stmt->execute();

    $conn->commit();

    require '/Smile-ify/Mail/phpmailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';

    $mail->Username = 'theartp2@gmail.com';
    $mail->Password = 'xnlc pyjn okdg ihwd';

    $mail->setFrom('theartp2@gmail.com', 'Smile-ify Team');
    $mail->addAddress($email);
    
    $mail->isHTML(true);
    $mail->Subject = "Login Credentials";
    $mail->Body = "<p>Dear $username,</p>
                    <p>Your Smile-ify account has been successfully verified.</p>
                    <p>Please use the following credentials to log in:</p>
                    <p>Username: $username</p>
                    <p>Password: $default_password</p>
                    <p>You can now log in to your account using these credentials.</p>
                    <p>Best regards,<br>Smile-ify Team</p>";

    try {
        error_log("Sending email...");
        if (!$mail->send()) {
            throw new Exception("Mailer Error: " . $mail->ErrorInfo);
        }

        error_log("Email sent successfully.");
        $_SESSION['otp_success'] = "Email has been sent with your login credentials.";
        header("Location: /Smile-ify/index.php");
        exit;
    } catch (Exception $e) {
        error_log("PHPMailer Exception: " . $e->getMessage());
        $_SESSION['otp_error'] = "Failed to send email. Please try again.";
        header("Location: /Smile-ify/includes/otp_verification.php");
        exit;
    }
$conn->close();
}

function generateUniqueUsername($lastName, $firstName, $middleName, $conn) {
    $username_base = $lastName . substr($firstName, 0, 1);
    $username = $username_base;
    $counter = 0;
    
    $check_sql = "SELECT username FROM users WHERE username = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_stmt->store_result();
    
    while ($check_stmt->num_rows > 0) {
        $counter++;
        $username = $username_base . substr($firstName, $counter - 1, 1);
        
        $check_stmt->execute();
        $check_stmt->store_result();
    }
    
    return $username;
}
?>
