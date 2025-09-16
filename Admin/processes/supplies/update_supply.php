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

    $supply_id = intval($_POST["supply_id"]);
    $name = trim($_POST["supplyName"]);
    $quantity = intval($_POST["quantity"]);
    $reorderLevel = intval($_POST["reorderLevel"]);
    $status = trim($_POST["status"]);

    $description = $_POST["description"] ?? null;
    $category = $_POST["category"] ?? null;
    $unit = $_POST["unit"] ?? null;
    $expiration_date = !empty($_POST["expiration_date"]) ? $_POST["expiration_date"] : null;

    try {
        $sql = "UPDATE supply 
                SET name=?, description=?, category=?, unit=?, quantity=?, reorder_level=?, expiration_date=?, branch_id=?, status=?, date_updated=NOW()
                WHERE supply_id=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiiissi", $name, $description, $category, $unit, $quantity, $reorderLevel, $expiration_date, $branch_id, $status, $supply_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $_SESSION['updateSuccess'] = "Supply updated successfully!";
            }
        } else {
            $_SESSION['updateError'] = "Failed to update supply. Please try again.";
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
