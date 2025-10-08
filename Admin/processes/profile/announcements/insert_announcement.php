<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: " . BASE_URL . "/index.php");
    exit;
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['updateError'] = "Unauthorized access.";
    header("Location: " . BASE_URL . "/index.php");
    exit;
}

$title        = trim($_POST["title"] ?? "");
$description  = trim($_POST["description"] ?? "");
$start_date   = $_POST["start_date"] ?? "";
$end_date     = $_POST["end_date"] ?? "";
$status       = $_POST["status"] ?? "Inactive";

try {
    $sql = "INSERT INTO announcements
            (title, description, start_date, end_date, status, date_created)
            VALUES (?, NULLIF(?, ''), NULLIF(?, ''), NULLIF(?, ''), ?, NOW())";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssss", $title, $description, $start_date, $end_date, $status);

    if ($stmt->execute()) {
        $_SESSION['updateSuccess'] = "Announcement added successfully!";
    } else {
        $_SESSION['updateError'] = "Failed to add announcement: " . $stmt->error;
    }

    $stmt->close();
} catch (Exception $e) {
    $_SESSION['updateError'] = "Database error: " . $e->getMessage();
}

header("Location: " . BASE_URL . "/Admin/pages/profile.php");
exit;

$conn->close();
