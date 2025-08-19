<?php
session_start();

$currentPage = 'profile';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    session_unset();
    session_destroy();
    header("Location: " . BASE_URL . "/index.php");
    exit();
}
require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Admin/includes/navbar.php';
?>
<title>Profile</title>

<div class="profile-container">
    <div class="profile-card" id="profileCard">
        <p>Loading profile...</p>
    </div>
</div>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>

