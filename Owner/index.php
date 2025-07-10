<?php 
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: /Smile-ify/index.php");
    exit;
}
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$currentPage = 'index';
include '../includes/header.php'; ?>

<body>
    <title>Home</title>
    <?php include 'includes/navbar.php'; ?>
    <h1>Hi, Welcome Owner</h1>

    <main>
        <h1>Hi, Welcome <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>You are logged in as <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong>.</p>
    </main>

<?php include '../includes/footer.php'; ?>
</body>
</html>
