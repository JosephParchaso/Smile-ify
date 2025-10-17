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
        $appointmentServices = $_SESSION['verified_data']['appointmentServices'];
        $appointmentDentist = $_SESSION['verified_data']['appointmentDentist'];
        $appointmentDate = $_SESSION['verified_data']['appointmentDate'];
        $appointmentTime = $_SESSION['verified_data']['appointmentTime'];
        $notes = $_SESSION['verified_data']['notes'];

        $username = generateUniqueUsername($lastName, $firstName, $conn);
        $default_password = generatePassword($lastName);
        $hashed_password = password_hash($default_password, PASSWORD_DEFAULT);

        try {
            $conn->begin_transaction();

            $user_sql = "INSERT INTO users 
                (username, password, last_name, middle_name, first_name, gender, date_of_birth, email, contact_number, role, branch_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'patient', ?)";
            $user_stmt = $conn->prepare($user_sql);
            $user_stmt->bind_param("sssssssssi", $username, $hashed_password, $lastName, $middleName, $firstName, $gender, $dateofBirth, $email, $contactNumber, $appointmentBranch);
            $user_stmt->execute();

            $user_id = $user_stmt->insert_id;

            if ($appointmentDentist === "none") {
                $appointmentDentist = null;
            }

            $appointment_sql = "INSERT INTO appointment_transaction 
                (user_id, branch_id, dentist_id, appointment_date, appointment_time, notes, status)
                VALUES (?, ?, ?, ?, ?, ?, 'Booked')";
            $appointment_stmt = $conn->prepare($appointment_sql);
            $appointment_stmt->bind_param("iiisss", $user_id, $appointmentBranch, $appointmentDentist, $appointmentDate, $appointmentTime, $notes);
            $appointment_stmt->execute();

            $appointment_transaction_id = $appointment_stmt->insert_id;

            if (!empty($_SESSION['verified_data']['appointmentServices']) && is_array($_SESSION['verified_data']['appointmentServices'])) {
                $service_ids = $_SESSION['verified_data']['appointmentServices'];
                $service_sql = "INSERT INTO appointment_services (appointment_transaction_id, service_id) VALUES (?, ?)";
                $service_stmt = $conn->prepare($service_sql);

                foreach ($service_ids as $service_id) {
                    $service_stmt->bind_param("ii", $appointment_transaction_id, $service_id);
                    $service_stmt->execute();
                }
            } else {
                throw new Exception("No services selected for appointment.");
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

        $servicesHtml = "";
        $totalPrice = 0;
        $totalDuration = 0;

        if (!empty($appointmentServices)) {
            $placeholders = implode(',', array_fill(0, count($appointmentServices), '?'));
            $types = str_repeat('i', count($appointmentServices));

            $stmt = $conn->prepare("SELECT name, price, duration_minutes FROM service WHERE service_id IN ($placeholders)");
            $stmt->bind_param($types, ...$appointmentServices);
            $stmt->execute();
            $result = $stmt->get_result();

            $servicesHtml .= "<ul>";
            while ($row = $result->fetch_assoc()) {
                $servicesHtml .= "<li>{$row['name']} - ₱" . number_format($row['price'], 2) . " ({$row['duration_minutes']} mins)</li>";
                $totalPrice += $row['price'];
                $totalDuration += (int)$row['duration_minutes'];
            }
            $servicesHtml .= "</ul>";
            $stmt->close();
        }

        $totalFormatted = number_format($totalPrice, 2);

        $appointmentDateTime = new DateTime("$appointmentDate $appointmentTime");
        $appointmentDateTime->modify("+{$totalDuration} minutes");
        $formattedEndTime = $appointmentDateTime->format('h:i A');

        $branch_sql = "SELECT address FROM branch WHERE branch_id = ?";
        $branch_stmt = $conn->prepare($branch_sql);
        $branch_stmt->bind_param("i", $appointmentBranch);
        $branch_stmt->execute();
        $branch_result = $branch_stmt->get_result();
        $branch_row = $branch_result->fetch_assoc();
        $branchAddress = $branch_row['address'] ?? 'N/A';
        $branch_stmt->close();

        require BASE_PATH . '/Mail/phpmailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Username = 'smileify.web@gmail.com';
        $mail->Password = '';

        $mail->setFrom('smileify.web@gmail.com', 'Smile-ify Team');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Smile-ify Login Credentials and Appointment Details";
        $mail->Body = "
            <p>Dear <strong>$username</strong>,</p>
            <p>Your Smile-ify account has been successfully verified.</p>
            <p>You may now log in using the following credentials:</p>
            <p>
                <strong>Username:</strong> $username<br>
                <strong>Password:</strong> $default_password
            </p>
            <hr>
            <p><strong>Appointment Details:</strong></p>
            <p>
                <strong>Date:</strong> $appointmentDate<br>
                <strong>Time:</strong> $appointmentTime<br>
                <strong>Estimated End Time:</strong> $formattedEndTime<br>
                <strong>Location:</strong> $branchAddress
            </p>
            <p><strong>Selected Services:</strong></p>
            $servicesHtml
            <p><strong>Total:</strong> ₱{$totalFormatted} ({$totalDuration} mins total)</p>
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

function generatePassword($lastName) {
    $cleanLastName = preg_replace("/[^a-zA-Z]/", "", $lastName);
    $prefix = strtolower($cleanLastName);
    $number = rand(1000, 9999);
    $specials = ['!', '@', '#', '$', '%'];
    $symbol = $specials[array_rand($specials)];
    return $prefix . $number . $symbol;
}
?>
