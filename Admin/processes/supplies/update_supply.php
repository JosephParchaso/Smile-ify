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
        $affected1 = 0;
        $affected2 = 0;

        $sqlCheck1 = "SELECT name, description, category, unit FROM supply WHERE supply_id = ?";
        $stmtCheck1 = $conn->prepare($sqlCheck1);
        $stmtCheck1->bind_param("i", $supply_id);
        $stmtCheck1->execute();
        $res1 = $stmtCheck1->get_result();
        $currentSupply = $res1->fetch_assoc();
        $stmtCheck1->close();

        $supplyChanged = false;
        if ($currentSupply) {
            if (
                $currentSupply['name'] !== $name ||
                $currentSupply['description'] !== $description ||
                $currentSupply['category'] !== $category ||
                $currentSupply['unit'] !== $unit
            ) {
                $supplyChanged = true;
            }
        }

        if ($supplyChanged) {
            $sql1 = "UPDATE supply 
                        SET name = ?, description = ?, category = ?, unit = ? 
                        WHERE supply_id = ?";
            $stmt1 = $conn->prepare($sql1);
            if (!$stmt1) {
                throw new Exception("Prepare failed (supply): " . $conn->error);
            }
            $stmt1->bind_param("ssssi", $name, $description, $category, $unit, $supply_id);
            $stmt1->execute();
            $affected1 = $stmt1->affected_rows;
            $stmt1->close();
        }

        $sqlCheck2 = "SELECT quantity, reorder_level, expiration_date, status 
                        FROM branch_supply 
                        WHERE supply_id = ? AND branch_id = ?";
        $stmtCheck2 = $conn->prepare($sqlCheck2);
        $stmtCheck2->bind_param("ii", $supply_id, $branch_id);
        $stmtCheck2->execute();
        $res2 = $stmtCheck2->get_result();
        $currentBranch = $res2->fetch_assoc();
        $stmtCheck2->close();

        $branchChanged = false;
        if ($currentBranch) {
            if (
                (int)$currentBranch['quantity'] !== $quantity ||
                (int)$currentBranch['reorder_level'] !== $reorderLevel ||
                ($currentBranch['expiration_date'] !== $expirationDate &&
                !($currentBranch['expiration_date'] === null && $expirationDate === null)) ||
                $currentBranch['status'] !== $status
            ) {
                $branchChanged = true;
            }
        }

        if ($branchChanged) {
            $sql2 = "UPDATE branch_supply 
                        SET quantity = ?, 
                            reorder_level = ?, 
                            expiration_date = ?, 
                            status = ?, 
                            date_updated = NOW()
                    WHERE supply_id = ? AND branch_id = ?";
            $stmt2 = $conn->prepare($sql2);
            if (!$stmt2) {
                throw new Exception("Prepare failed (branch_supply): " . $conn->error);
            }
            $stmt2->bind_param("iissii", $quantity, $reorderLevel, $expirationDate, $status, $supply_id, $branch_id);
            $stmt2->execute();
            $affected2 = $stmt2->affected_rows;
            $stmt2->close();
        }

        if ($affected1 > 0 || $affected2 > 0) {
            $_SESSION['updateSuccess'] = "Supply updated successfully!";
        }

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
