<?php
session_start();

$currentPage = 'profile';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Admin/includes/navbar.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}
?>
<title>Profile</title>

<div class="profile-container">
    <div class="profile-card" id="profileCard">
        <p>Loading profile...</p>
    </div>
</div>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>

