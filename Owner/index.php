<?php 
session_start();
$baseUrl = $_SERVER['HTTP_HOST'] === 'localhost' ? '/Smile-ify' : '';

if (!isset($_SESSION['username'])) {
    header("Location: $baseUrl/index.php");
    exit;
}
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$currentPage = 'index';

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/header.php'; 
?>

<body>
    <title>Home</title>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/Owner/includes/navbar.php'; ?>
    <h1>Hi, Welcome Owner</h1>

    <main>
        <h1>Hi, Welcome <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>You are logged in as <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong>.</p>
    </main>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/footer.php'; ?>
</body>
