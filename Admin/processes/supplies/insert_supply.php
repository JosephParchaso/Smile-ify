<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $branch_id = $_SESSION['branch_id'] ?? null;

    if (!$branch_id) {
        $_SESSION['updateError'] = "Branch not set. Please log in again.";
        header("Location: " . BASE_URL . "/index.php");
        exit;
    }

    $name = trim($_POST["supplyName"]);
    $quantity = intval($_POST["quantity"]);
    $reorderLevel = intval($_POST["reorderLevel"]);
    $status = trim($_POST["status"]);

    $description = $_POST["description"] ?? null;
    $category = $_POST["category"] ?? null;
    $unit = $_POST["unit"] ?? null;
    $expiration_date = !empty($_POST["expiration_date"]) ? $_POST["expiration_date"] : null;

    try {
        $sql = "INSERT INTO supply
                (name, description, category, unit, quantity, reorder_level, expiration_date, branch_id, status, date_created) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiiiss", $name, $description, $category, $unit, $quantity, $reorderLevel, $expiration_date, $branch_id, $status);

        if ($stmt->execute()) {
            $_SESSION['updateSuccess'] = "Supply added successfully!";
        } else {
            $_SESSION['updateError'] = "Failed to add supply. Please try again.";
        }

        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['updateError'] = "Database error: " . $e->getMessage();
    }

    header("Location: " . BASE_URL . "/Admin/pages/supplies.php");
    exit;
} else {
    header("Location: " . BASE_URL . "/index.php");
    exit;
}

$conn->close();
