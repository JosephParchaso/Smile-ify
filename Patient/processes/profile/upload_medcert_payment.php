<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    $_SESSION['updateError'] = "Unauthorized access.";
    header("Location: " . BASE_URL . "/Patient/pages/profile.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_FILES['payment_receipt']) || $_FILES['payment_receipt']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['updateError'] = "No file uploaded or upload error.";
    header("Location: " . BASE_URL . "/Patient/pages/profile.php");
    exit();
}

if (!isset($_POST['dental_transaction_id'])) {
    $_SESSION['updateError'] = "Missing transaction ID.";
    header("Location: " . BASE_URL . "/Patient/pages/profile.php");
    exit();
}

$transaction_id = intval($_POST['dental_transaction_id']);

$stmtUser = $conn->prepare("SELECT first_name, middle_name, last_name FROM users WHERE user_id = ?");
$stmtUser->bind_param("i", $user_id);
$stmtUser->execute();
$stmtUser->bind_result($first_name, $middle_name, $last_name);
$stmtUser->fetch();
$stmtUser->close();

$last_name_clean = preg_replace('/[^a-zA-Z0-9_-]/', '', strtolower($last_name));

$middle_initial = $middle_name ? strtoupper(substr($middle_name, 0, 1)) . '. ' : '';
$patient_fullname = $first_name . ' ' . $middle_initial . $last_name;

$fileTmpPath = $_FILES['payment_receipt']['tmp_name'];
$fileSize = $_FILES['payment_receipt']['size'];
$fileType = mime_content_type($fileTmpPath);
$fileExt = strtolower(pathinfo($_FILES['payment_receipt']['name'], PATHINFO_EXTENSION));

$allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
$maxFileSize = 5 * 1024 * 1024;

if (!in_array($fileType, $allowedTypes)) {
    $_SESSION['updateError'] = "Invalid image type. Allowed: JPG, PNG, WEBP.";
    header("Location: " . BASE_URL . "/Patient/pages/profile.php");
    exit();
}

if ($fileSize > $maxFileSize) {
    $_SESSION['updateError'] = "Image exceeds 5MB limit.";
    header("Location: " . BASE_URL . "/Patient/pages/profile.php");
    exit();
}

$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/images/medcert_payments/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

$fileName = $transaction_id . "_" . $last_name_clean . "." . $fileExt;
$targetPath = $uploadDir . $fileName;

$oldFiles = glob($uploadDir . $transaction_id . "_*.*");
foreach ($oldFiles as $oldFile) {
    if (is_file($oldFile)) unlink($oldFile);
}

if (move_uploaded_file($fileTmpPath, $targetPath)) {
    $imagePath = "/images/medcert_payments/" . $fileName;

    $checkSql = "
        SELECT dt.dental_transaction_id, atx.appointment_transaction_id, atx.branch_id
        FROM dental_transaction dt
        INNER JOIN appointment_transaction atx
            ON dt.appointment_transaction_id = atx.appointment_transaction_id
        WHERE dt.dental_transaction_id = ? AND atx.user_id = ?
    ";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ii", $transaction_id, $user_id);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows === 0) {
        $_SESSION['updateError'] = "Transaction not found or not owned by this user.";
        header("Location: " . BASE_URL . "/Patient/pages/profile.php");
        exit();
    }

    $checkStmt->bind_result($dt_id, $appointment_transaction_id, $branch_id);
    $checkStmt->fetch();
    $checkStmt->close();

    $expiryCheckSql = "SELECT date_created FROM dental_transaction WHERE dental_transaction_id = ?";
    $expiryStmt = $conn->prepare($expiryCheckSql);
    $expiryStmt->bind_param("i", $transaction_id);
    $expiryStmt->execute();
    $expiryStmt->bind_result($date_created);
    $expiryStmt->fetch();
    $expiryStmt->close();

    $updateSql = "
        UPDATE dental_transaction
        SET med_cert_status = 'Requested',
            medcert_receipt = ?,
            date_updated = NOW()
        WHERE dental_transaction_id = ?
    ";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("si", $imagePath, $transaction_id);

    if ($updateStmt->execute()) {
        $_SESSION['updateSuccess'] = "Your medical certificate request has been submitted successfully!";

        $notifySql = "
            INSERT INTO notifications (user_id, message, is_read, date_created)
            SELECT u.user_id,
                    CONCAT('Patient ', ?, ' has requested a medical certificate for transaction #', ?),
                    0,
                    NOW()
            FROM users u
            WHERE u.role = 'admin' AND u.branch_id = ?
        ";
        $notifyStmt = $conn->prepare($notifySql);
        $notifyStmt->bind_param("sii", $patient_fullname, $transaction_id, $branch_id);
        $notifyStmt->execute();
        $notifyStmt->close();
    } else {
        $_SESSION['updateError'] = "Database error. Please try again.";
    }

    $updateStmt->close();
} else {
    $_SESSION['updateError'] = "File upload failed. Please try again.";
}

header("Location: " . BASE_URL . "/Patient/pages/profile.php");
exit();
?>
