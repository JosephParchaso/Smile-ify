<?php
session_start();

$currentPage = 'about';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Owner/includes/navbar.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}
?>

<title>About</title>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
