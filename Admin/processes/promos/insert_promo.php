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
    $start_date = !empty($_POST["startDate"]) ? $_POST["startDate"] : null;
    $end_date   = !empty($_POST["endDate"])   ? $_POST["endDate"]   : null;

    $image_path = null;
    if (isset($_FILES['promoImage']) && $_FILES['promoImage']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $maxFileSize = 5 * 1024 * 1024;

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

        $extension = pathinfo($_FILES["promoImage"]["name"], PATHINFO_EXTENSION);
        $fileName = uniqid("promo_") . "." . strtolower($extension);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $targetPath)) {
            $image_path = BASE_URL . "/images/promos/" . $fileName;
        } else {
            $_SESSION['updateError'] = "Image upload failed.";
            header("Location: " . BASE_URL . "/Admin/pages/promos.php");
            exit;
        }
    }

    try {
        $sql = "INSERT INTO promo (name, image_path, description, discount_type, discount_value) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed (promo): " . $conn->error);
        }
        $stmt->bind_param("ssssd", $name, $image_path, $description, $discount_type, $discount_value);

        if ($stmt->execute()) {
            $promo_id = $stmt->insert_id;
            $stmt->close();

            $sql2 = "INSERT INTO branch_promo 
                        (branch_id, promo_id, status, start_date, end_date, date_created, date_updated) 
                    VALUES (?, ?, ?, " . ($start_date ? "?" : "NULL") . ", " . ($end_date ? "?" : "NULL") . ", NOW(), NOW())";
            $stmt2 = $conn->prepare($sql2);
            if (!$stmt2) {
                throw new Exception("Prepare failed (branch_promo): " . $conn->error);
            }
            $stmt2->bind_param("iisss", $branch_id, $promo_id, $status, $start_date, $end_date);
            $stmt2->execute();
            $stmt2->close();

            $_SESSION['updateSuccess'] = "Promo added successfully!";
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
