<?php
session_start();

$currentPage = 'reports';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    session_unset();
    session_destroy();
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Owner/includes/navbar.php';

require_once BASE_PATH . '/includes/db.php';
$sql = "SELECT branch_id, name, address, phone_number, status FROM branch";
$result = $conn->query($sql);

$branches = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $branches[] = $row;
    }
}
$conn->close();
?>
<title>Reports</title>

<div class="tabs-container">
    <div class="tabs">
        <?php foreach ($branches as $i => $branch): ?>
            <div class="tab <?= $i === 0 ? 'active' : '' ?>" onclick="switchTab('branch<?= $branch['branch_id'] ?>')">
                <?= htmlspecialchars($branch['name']) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?php foreach ($branches as $i => $branch): ?>
        <div class="tab-content <?= $i === 0 ? 'active' : '' ?>" id="branch<?= $branch['branch_id'] ?>">
        </div>
    <?php endforeach; ?>
</div>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
