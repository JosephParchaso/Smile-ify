<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: " . BASE_URL . "/index.php");
    exit;
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    $_SESSION['updateError'] = "Unauthorized access.";
    header("Location: " . BASE_URL . "/index.php");
    exit;
}

$branchName   = trim($_POST["branchName"] ?? "");
$address      = trim($_POST["address"] ?? "");
$phone_number = trim($_POST["contactNumber"] ?? "");
$openingTime  = $_POST["opening_time"] ?? "";
$closingTime  = $_POST["closing_time"] ?? "";
$map_url       = trim($_POST["map_url"] ?? "");
$status       = $_POST["status"] ?? "Active";

try {
    $sql = "INSERT INTO branch
            (name, address, phone_number, opening_time, closing_time, status, map_url, date_created)
            VALUES (?, ?, ?, NULLIF(?, ''), NULLIF(?, ''), ?, NULLIF(?, ''), NOW())";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssssss", $branchName, $address, $phone_number, $openingTime, $closingTime, $status, $map_url);

    if ($stmt->execute()) {
        $_SESSION['updateSuccess'] = "Branch added successfully!";
    } else {
        $_SESSION['updateError'] = "Failed to add branch: " . $stmt->error;
    }

    $stmt->close();
} catch (Exception $e) {
    $_SESSION['updateError'] = "Database error: " . $e->getMessage();
}

header("Location: " . BASE_URL . "/Owner/pages/branches.php");
exit;

$conn->close();