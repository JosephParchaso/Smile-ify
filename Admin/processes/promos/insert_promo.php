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

    $name           = trim($_POST["promoName"]);
    $description    = trim($_POST["description"]);
    $discount_type  = trim($_POST["discountType"]);
    $discount_value = floatval($_POST["discountValue"]);
    $status         = trim($_POST["status"]);
    $start_date     = !empty($_POST["startDate"]) ? $_POST["startDate"] : null;
    $end_date       = !empty($_POST["endDate"])   ? $_POST["endDate"]   : null;

    $image_path = null;

    try {
        $sql = "INSERT INTO promo (name, description, discount_type, discount_value) 
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssd", $name, $description, $discount_type, $discount_value);

        if ($stmt->execute()) {
            $promo_id = $stmt->insert_id;
            $stmt->close();

            if (isset($_FILES['promoImage']) && $_FILES['promoImage']['error'] === UPLOAD_ERR_OK) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                $maxFileSize  = 5 * 1024 * 1024;

                $fileTmpPath = $_FILES['promoImage']['tmp_name'];
                $fileType    = mime_content_type($fileTmpPath);
                $fileSize    = $_FILES['promoImage']['size'];

                if (!in_array($fileType, $allowedTypes)) {
                    $_SESSION['updateError'] = "Invalid image type. Allowed: JPG, PNG, WEBP.";
                    header("Location: " . BASE_URL . "/Admin/pages/promos.php");
                    exit;
                }

                if ($fileSize > $maxFileSize) {
                    $_SESSION['updateError'] = "Image size exceeds 5MB limit.";
                    header("Location: " . BASE_URL . "/Admin/pages/promos.php");
                    exit;
                }

                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/images/promos/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $extension = strtolower(pathinfo($_FILES["promoImage"]["name"], PATHINFO_EXTENSION));
                $fileName  = "promo_" . $promo_id . "." . $extension;
                $targetPath = $uploadDir . $fileName;

                $oldFiles = glob($uploadDir . "promo_" . $promo_id . ".*");
                foreach ($oldFiles as $oldFile) {
                    if (is_file($oldFile)) unlink($oldFile);
                }

                if (move_uploaded_file($fileTmpPath, $targetPath)) {
                    $image_path = "/images/promos/" . $fileName;

                    $sql = "UPDATE promo SET image_path = ? WHERE promo_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $image_path, $promo_id);
                    $stmt->execute();
                    $stmt->close();
                }
            }

            $sql2 = "INSERT INTO branch_promo 
                        (branch_id, promo_id, status, start_date, end_date, date_created, date_updated) 
                        VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("iisss", $branch_id, $promo_id, $status, $start_date, $end_date);
            $stmt2->execute();
            $stmt2->close();

            $_SESSION['updateSuccess'] = "Promo added successfully!";

            $notif_message = "";
            $branch_name = "";

            $branchQuery = $conn->prepare("SELECT name FROM branch WHERE branch_id = ?");
            $branchQuery->bind_param("i", $branch_id);
            $branchQuery->execute();
            $branchResult = $branchQuery->get_result();

            if ($branchResult->num_rows > 0) {
                $branchRow = $branchResult->fetch_assoc();
                $branch_name = $branchRow['name'];
            }
            $branchQuery->close();

            $notif_message = "The promo " . $name . " has been updated in " . $branch_name . ".";

            $getOwners = $conn->prepare("SELECT user_id FROM users WHERE role = 'owner' AND status = 'Active'");
            $getOwners->execute();
            $ownersResult = $getOwners->get_result();

            if ($ownersResult->num_rows > 0) {
                $notifSQL = "INSERT INTO notifications (user_id, message, is_read, date_created) VALUES (?, ?, 0, NOW())";
                $notifStmt = $conn->prepare($notifSQL);

                while ($owner = $ownersResult->fetch_assoc()) {
                    $notifStmt->bind_param("is", $owner['user_id'], $notif_message);
                    $notifStmt->execute();
                }

                $notifStmt->close();
            }
            $getOwners->close();

        } else {
            $_SESSION['updateError'] = "Failed to add promo: " . $stmt->error;
            $stmt->close();
        }
    } catch (Exception $e) {
        $_SESSION['updateError'] = "Database error: " . $e->getMessage();
    }

    header("Location: " . BASE_URL . "/Admin/pages/promos.php");
    exit;
} else {
    header("Location: " . BASE_URL . "/index.php");
    exit;
}

$conn->close();
