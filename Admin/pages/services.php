<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

$currentPage = 'services';

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Admin/includes/navbar.php';
?>

<title>Services</title>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>

