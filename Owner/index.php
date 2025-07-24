<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "/index.php");
    exit;
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$currentPage = 'index';
$otpSuccess = '';

if (isset($_SESSION['error_msg'])) {
    $error_msg = $_SESSION['error_msg'];
    unset($_SESSION['error_msg']);
}

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Owner/includes/navbar.php';
?>

<body>
    <title>Home</title>
    <h1>Hi, Welcome Owner</h1>

    <main>
        <h1>Hi, Welcome <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>You are logged in as <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong>.</p>
    </main>

    <?php require_once BASE_PATH . '/includes/footer.php'; ?>
</body>
