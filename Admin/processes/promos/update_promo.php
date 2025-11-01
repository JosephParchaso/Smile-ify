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

    $promo_id       = intval($_POST["promo_id"]);
    $name           = trim($_POST["promoName"]);
    $description    = trim($_POST["description"]);
    $discount_type  = trim($_POST["discountType"]);
    $discount_value = floatval($_POST["discountValue"]);
    $status         = trim($_POST["status"]);
    $start_date     = !empty($_POST["startDate"]) ? $_POST["startDate"] : null;
    $end_date       = !empty($_POST["endDate"])   ? $_POST["endDate"]   : null;

    $image_path = null;

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
        }
    }

    try {
        $checkSql = "SELECT p.name, p.description, p.discount_type, p.discount_value, p.image_path,
                            bp.status, bp.start_date, bp.end_date
                        FROM promo p
                        JOIN branch_promo bp ON p.promo_id = bp.promo_id
                        WHERE p.promo_id = ? AND bp.branch_id = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("ii", $promo_id, $branch_id);
        $checkStmt->execute();
        $current = $checkStmt->get_result()->fetch_assoc();
        $checkStmt->close();

        if (!$current) {
            $_SESSION['updateError'] = "Promo not found.";
            header("Location: " . BASE_URL . "/Admin/pages/promos.php");
            exit;
        }

        $promoChanged = (
            $current['name'] !== $name ||
            $current['description'] !== $description ||
            $current['discount_type'] !== $discount_type ||
            floatval($current['discount_value']) !== $discount_value ||
            ($image_path !== null)
        );

        $branchChanged = (
            $current['status'] !== $status ||
            $current['start_date'] !== $start_date ||
            $current['end_date'] !== $end_date
        );

        if ($promoChanged || $branchChanged) {

            if ($promoChanged) {
                if ($image_path) {
                    $sql = "UPDATE promo 
                            SET name = ?, image_path = ?, description = ?, discount_type = ?, discount_value = ?
                            WHERE promo_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssssdi", $name, $image_path, $description, $discount_type, $discount_value, $promo_id);
                } else {
                    $sql = "UPDATE promo 
                            SET name = ?, description = ?, discount_type = ?, discount_value = ?
                            WHERE promo_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssdi", $name, $description, $discount_type, $discount_value, $promo_id);
                }
                $stmt->execute();
                $stmt->close();
            }

            $sql2 = "UPDATE branch_promo 
                        SET status = ?, start_date = ?, end_date = ?, date_updated = NOW()
                        WHERE branch_id = ? AND promo_id = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("sssii", $status, $start_date, $end_date, $branch_id, $promo_id);
            $stmt2->execute();
            $stmt2->close();

            $_SESSION['updateSuccess'] = "Promo updated successfully!";

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

            $notif_message = "The promo " . htmlspecialchars($name) . " has been updated in " . htmlspecialchars($branch_name) . ".";

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
?>
