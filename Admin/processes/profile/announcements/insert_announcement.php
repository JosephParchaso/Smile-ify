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

if (!isset($_SESSION['branch_id'])) {
    $_SESSION['updateError'] = "Branch ID not found. Please log in again.";
    header("Location: " . BASE_URL . "/index.php");
    exit;
}

$title        = trim($_POST["title"] ?? "");
$description  = trim($_POST["description"] ?? "");
$type         = trim($_POST["type"] ?? "General");
$start_date   = $_POST["start_date"] ?? null;
$end_date     = $_POST["end_date"] ?? null;
$status       = $_POST["status"] ?? "Inactive";
$branch_id    = intval($_SESSION['branch_id']);

try {
    $conn->begin_transaction();

    $sql = "INSERT INTO announcements (title, description, type) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sss", $title, $description, $type);
    $stmt->execute();
    $announcement_id = $stmt->insert_id;
    $stmt->close();

    $sql2 = "
        INSERT INTO branch_announcements 
            (branch_id, announcement_id, start_date, end_date, status, date_created)
        VALUES (?, ?, NULLIF(?, ''), NULLIF(?, ''), ?, NOW())
    ";
    $stmt2 = $conn->prepare($sql2);
    if (!$stmt2) {
        throw new Exception("Prepare failed (branch link): " . $conn->error);
    }

    $stmt2->bind_param("iisss", $branch_id, $announcement_id, $start_date, $end_date, $status);
    $stmt2->execute();
    $stmt2->close();

    $conn->commit();
    $_SESSION['updateSuccess'] = "Announcement added successfully!";
} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['updateError'] = "Database error: " . $e->getMessage();
}

header("Location: " . BASE_URL . "/Admin/pages/profile.php");
exit;

$conn->close();
