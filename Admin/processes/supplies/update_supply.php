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

    $supply_id      = intval($_POST["supply_id"]);
    $name           = trim($_POST["supplyName"]);
    $quantity       = intval($_POST["quantity"]);
    $reorderLevel   = intval($_POST["reorderLevel"]);
    $status         = trim($_POST["status"]);
    $description    = $_POST["description"] ?? null;
    $category       = $_POST["category"] ?? null;
    $unit           = $_POST["unit"] ?? null;
    $expirationDate = !empty($_POST["expiration_date"]) ? $_POST["expiration_date"] : null;

    if ($expirationDate !== null) {
        $d = DateTime::createFromFormat('Y-m-d', $expirationDate);
        if (!$d || $d->format('Y-m-d') !== $expirationDate) {
            $expirationDate = null;
        }
    }

    try {
        $sql1 = "UPDATE supply 
                    SET name = ?, description = ?, category = ?, unit = ? 
                    WHERE supply_id = ?";
        $stmt1 = $conn->prepare($sql1);
        if (!$stmt1) {
            throw new Exception("Prepare failed (supply): " . $conn->error);
        }
        $stmt1->bind_param("ssssi", $name, $description, $category, $unit, $supply_id);
        $stmt1->execute();
        $stmt1->close();

        $sql2 = "UPDATE branch_supply 
                        SET quantity = ?, reorder_level = ?, expiration_date = ?, status = ?, date_updated = NOW() 
                    WHERE supply_id = ? AND branch_id = ?";
        $stmt2 = $conn->prepare($sql2);
        if (!$stmt2) {
            throw new Exception("Prepare failed (branch_supply): " . $conn->error);
        }
        $stmt2->bind_param("iissii", $quantity, $reorderLevel, $expirationDate, $status, $supply_id, $branch_id);

        if ($stmt2->execute()) {
            if ($stmt2->affected_rows > 0) {
                $_SESSION['updateSuccess'] = "Supply updated successfully!";
            } else {
                $_SESSION['updateError'] = "No changes were made.";
            }
        } else {
            $_SESSION['updateError'] = "Failed to update branch supply: " . $stmt2->error;
        }

        $stmt2->close();
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
