<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

function isValidEmailDomain($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    $domain = substr(strrchr($email, "@"), 1);
    return checkdnsrr($domain, "MX");
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

    $check_stmt->close();
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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $lastName            = trim($_POST['lastName']);
    $firstName           = trim($_POST['firstName']);
    $middleName          = trim($_POST['middleName']);
    $gender              = $_POST['gender'];
    $dateofBirth         = $_POST['dateofBirth'];
    $email               = trim($_POST['email']);
    $contactNumber       = trim($_POST['contactNumber']);
    $appointmentBranch   = $_POST['appointmentBranch'];
    $appointmentService  = $_POST['appointmentService'];
    $appointmentDentist  = $_POST['appointmentDentist'];
    $appointmentDate     = $_POST['appointmentDate'];
    $appointmentTime     = $_POST['appointmentTime'];
    $notes               = $_POST['notes'];

    if ($appointmentDentist === "none" || empty($appointmentDentist)) {
        $appointmentDentist = null;
    }

    if (!isValidEmailDomain($email)) {
        $_SESSION['updateError'] = "Invalid or unreachable email domain.";
        header("Location: " . BASE_URL . "/Admin/index.php");
        exit();
    }

    try {
        $conn->begin_transaction();

        $username = generateUniqueUsername($lastName, $firstName, $conn);
        $default_password = generatePassword($lastName);
        $hashed_password  = password_hash($default_password, PASSWORD_DEFAULT);

        $insert_patient = $conn->prepare("
            INSERT INTO users 
            (username, password, last_name, first_name, middle_name, gender, date_of_birth, email, contact_number, role, status, branch_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'patient', 'Active', ?)
        ");
        $insert_patient->bind_param(
            "sssssssssi",
            $username, $hashed_password, $lastName, $firstName, $middleName, $gender,
            $dateofBirth, $email, $contactNumber, $appointmentBranch
        );
        $insert_patient->execute();
        $user_id = $insert_patient->insert_id;
        $insert_patient->close();

        $appointment_sql = "
            INSERT INTO appointment_transaction 
            (user_id, branch_id, service_id, dentist_id, appointment_date, appointment_time, notes, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'Booked')
        ";
        $appointment_stmt = $conn->prepare($appointment_sql);
        $appointment_stmt->bind_param(
            "iiissss",
            $user_id, $appointmentBranch, $appointmentService,
            $appointmentDentist, $appointmentDate, $appointmentTime, $notes
        );
        $appointment_stmt->execute();
        $appointment_stmt->close();

        $welcome_msg = "Welcome to Smile-ify! Your account was created.";
        $welcome_sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
        $welcome_stmt = $conn->prepare($welcome_sql);
        $welcome_stmt->bind_param("is", $user_id, $welcome_msg);
        $welcome_stmt->execute();
        $welcome_stmt->close();

        $msg = "Your appointment on $appointmentDate at $appointmentTime was successfully booked!";
        $notif_sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
        $notif_stmt = $conn->prepare($notif_sql);
        $notif_stmt->bind_param("is", $user_id, $msg);
        $notif_stmt->execute();
        $notif_stmt->close();

        $conn->commit();

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
            <p>Your Smile-ify account has been successfully created.</p>
            <p>You may now log in using the following credentials:</p>
            <p><strong>Username:</strong> $username<br>
            <strong>Password:</strong> $default_password</p>
            <br>
            <p><i>Smile with confidence.</i></p>
            <p>Best regards,<br><strong>Smile-ify</strong></p>
        ";

        if (!$mail->send()) {
            throw new Exception("Mailer Error: " . $mail->ErrorInfo);
        }

        $_SESSION['updateSuccess'] = "Walk-in patient booked and credentials emailed successfully.";
        header("Location: " . BASE_URL . "/Admin/pages/calendar.php");
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        error_log("Error booking walk-in appointment: " . $e->getMessage());
        $_SESSION['updateError'] = "Failed to book walk-in appointment. Please try again.";
        header("Location: " . BASE_URL . "/Admin/index.php");
        exit;
    }
}
?>
