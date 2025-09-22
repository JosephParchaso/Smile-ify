<?php
session_start();

$currentPage = 'branches';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    session_unset();
    session_destroy();
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Owner/includes/navbar.php';

$updateSuccess = $_SESSION['updateSuccess'] ?? '';
$updateError   = $_SESSION['updateError'] ?? '';
?>

<title>Branches</title>

<?php if (!empty($updateSuccess) || !empty($updateError)): ?>
    <div id="toastContainer">
        <?php if (!empty($updateSuccess)): ?>
            <div class="toast success"><?= htmlspecialchars($updateSuccess) ?></div>
            <?php unset($_SESSION['updateSuccess']); ?>
        <?php endif; ?>

        <?php if (!empty($updateError)): ?>
            <div class="toast error"><?= htmlspecialchars($updateError) ?></div>
            <?php unset($_SESSION['updateError']); ?>
        <?php endif; ?>
    </div>
<?php endif; ?>

<div class="branches-table">
    <table id="branchesTable" class="transaction-table"></table>
</div>

<div id="manageBranchModal" class="manage-branch-modal">
    <div class="manage-branch-modal-content">
        <div id="branchModalBody" class="manage-branch-modal-content-body">
            <!-- Branch info will be loaded here -->
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
