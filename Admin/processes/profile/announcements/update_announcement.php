<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        $_SESSION['updateError'] = "Unauthorized access.";
        header("Location: " . BASE_URL . "/index.php");
        exit;
    }

    $announcement_id = intval($_POST["announcement_id"] ?? 0);
    $title           = trim($_POST["title"] ?? "");
    $description     = trim($_POST["description"] ?? "");
    $start_date      = !empty($_POST["start_date"]) ? $_POST["start_date"] : null;
    $end_date        = !empty($_POST["end_date"]) ? $_POST["end_date"] : null;
    $status          = $_POST["status"] ?? "Inactive";

    try {
        $check_sql = "SELECT title, description, start_date, end_date, status 
                        FROM announcements 
                        WHERE announcement_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $announcement_id);
        $check_stmt->execute();
        $current = $check_stmt->get_result()->fetch_assoc();
        $check_stmt->close();

        if (!$current) {
            $_SESSION['updateError'] = "Announcement not found.";
        } else {
            if (
                $current['title'] !== $title ||
                $current['description'] !== $description ||
                $current['start_date'] !== $start_date ||
                $current['end_date'] !== $end_date ||
                $current['status'] !== $status
            ) {
                $sql = "UPDATE announcements
                        SET title = ?, 
                            description = ?, 
                            start_date = ?, 
                            end_date = ?, 
                            status = ?
                        WHERE announcement_id = ?";

                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }

                $stmt->bind_param("sssssi",
                    $title,
                    $description,
                    $start_date,
                    $end_date,
                    $status,
                    $announcement_id
                );

                if ($stmt->execute() && $stmt->affected_rows > 0) {
                    $_SESSION['updateSuccess'] = "Announcement updated successfully!";
                }

                $stmt->close();
            }
        }
    } catch (Exception $e) {
        $_SESSION['updateError'] = "Database error: " . $e->getMessage();
    }

    header("Location: " . BASE_URL . "/Admin/pages/profile.php");
    exit;
} else {
    header("Location: " . BASE_URL . "/index.php");
    exit;
}

$conn->close();
