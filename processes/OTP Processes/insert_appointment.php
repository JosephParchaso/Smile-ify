<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["verify"])) {
    $otp = $_SESSION['otp'] ?? null;
    $otp_code = trim($_POST['otpCode']);
    $otp_created = $_SESSION['otp_created'] ?? 0;
    $expiry_limit = 60;
    $email = $_SESSION['mail'] ?? null;

    if (time() - $otp_created > $expiry_limit) {
        $_SESSION['otp_error'] = "OTP has expired. Please request a new one.";
        header("Location: " . BASE_URL . "/includes/OTP Includes/otp_verification.php");
        exit;
    }

    if ((string)$otp !== (string)$otp_code) {
        $_SESSION['otp_error'] = "Invalid OTP code.";
        header("Location: " . BASE_URL . "/includes/OTP Includes/otp_verification.php");
        exit;
    }

    if (isset($_SESSION['verified_data'])) {
        $lastName = $_SESSION['verified_data']['lastName'];
        $firstName = $_SESSION['verified_data']['firstName'];
        $middleName = $_SESSION['verified_data']['middleName'];
        $email = $_SESSION['verified_data']['email'];
        $gender = $_SESSION['verified_data']['gender'];
        $dateofBirth = $_SESSION['verified_data']['dateofBirth'];
        $contactNumber = $_SESSION['verified_data']['contactNumber'];

        $appointmentBranch = $_SESSION['verified_data']['appointmentBranch'];
        $appointmentService = $_SESSION['verified_data']['appointmentService'];
        $appointmentDentist = $_SESSION['verified_data']['appointmentDentist'];
        $appointmentDate = $_SESSION['verified_data']['appointmentDate'];
        $appointmentTime = $_SESSION['verified_data']['appointmentTime'];
        $notes = $_SESSION['verified_data']['notes'];

        $username = generateUniqueUsername($lastName, $firstName, $conn);
        $default_password = "passworduser";
        $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);

        try {
            $conn->begin_transaction();

            $user_sql = "INSERT INTO users 
                                    (username, password, last_name, middle_name, first_name, gender, date_of_birth, email, contact_number, role, branch_id)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'patient', ?)";
            $user_stmt = $conn->prepare($user_sql);
            $user_stmt->bind_param("sssssssssi", $username, $hashed_password, $lastName, $middleName, $firstName, $gender, $dateofBirth, $email, $contactNumber, $appointmentBranch);

            if (!$user_stmt->execute()) {
                throw new Exception("User insert failed: " . $user_stmt->error);
            }

            $user_id = $user_stmt->insert_id;

            if ($appointmentDentist === "none") {
                $appointmentDentist = null;
            }

            $appointment_sql = "INSERT INTO appointment_transaction 
                (user_id, branch_id, service_id, dentist_id, appointment_date, appointment_time, notes, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')";
            $appointment_stmt = $conn->prepare($appointment_sql);
            $appointment_stmt->bind_param("iiiisss", $user_id, $appointmentBranch, $appointmentService, $appointmentDentist, $appointmentDate, $appointmentTime, $notes
            );

            if (!$appointment_stmt->execute()) {
                throw new Exception("Appointment insert failed: " . $appointment_stmt->error);
            }

            $welcome_msg = "Welcome to Smile-ify! Your account was successfully created.";
            $welcome_sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
            $welcome_stmt = $conn->prepare($welcome_sql);
            $welcome_stmt->bind_param("is", $user_id, $welcome_msg);
            $welcome_stmt->execute();

            $msg = "Your appointment on $appointmentDate at $appointmentTime was successfully booked!";
            $notif_sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
            $notif_stmt = $conn->prepare($notif_sql);
            $notif_stmt->bind_param("is", $user_id, $msg);
            $notif_stmt->execute();

            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            error_log("Transaction failed: " . $e->getMessage());
            $_SESSION['otp_error'] = "Something went wrong during account creation. Please try again.";
            header("Location: " . BASE_URL . "/includes/OTP Includes/otp_verification.php");
            exit;
        }

        require BASE_PATH . '/Mail/phpmailer/PHPMailerAutoload.php';
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
        $mail->Subject = "Smile-ify Login Credentials";
        $mail->Body = "
            <p>Dear <strong>$username</strong>,</p>
            <p>Your Smile-ify account has been successfully verified.</p>
            <p>You may now log in using the following credentials:</p>
            <p><strong>Username:</strong> $username<br>
            <strong>Password:</strong> $default_password</p>
            <br>
            <p><i>Smile with confidence.</i></p>
            <p>Best regards,<br><strong>Smile-ify</strong></p>
        ";

        try {
            if (!$mail->send()) {
                throw new Exception("Mailer Error: " . $mail->ErrorInfo);
            }

            $_SESSION['login_success'] = "Email has been sent with your login credentials.";
            header("Location: " . BASE_URL . "/index.php");
            exit;
        } catch (Exception $e) {
            error_log("PHPMailer Exception: " . $e->getMessage());
            $_SESSION['otp_error'] = "Failed to send email. Please try again.";
            header("Location: " . BASE_URL . "/includes/OTP Includes/otp_verification.php");
            exit;
        }
    }

    $conn->close();
}

function generateUniqueUsername($lastName, $firstName, $conn) {
    $username_base = $lastName . '_' . strtoupper(substr($firstName, 0, 1));
    $username = $username_base;
    $counter = 0;

    $check_sql = "SELECT username FROM users WHERE username = ?";
    $check_stmt = $conn->prepare($check_sql);

    do {
        if ($counter > 0) {
            $username = $username_base . $counter;
        }

        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_stmt->store_result();
        $counter++;
    } while ($check_stmt->num_rows > 0);

    return $username;
}
?>
