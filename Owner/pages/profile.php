<?php
session_start();

$currentPage = 'profile';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    session_unset();
    session_destroy();
    header("Location: " . BASE_URL . "/index.php");
    exit();
}
require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Owner/includes/navbar.php';  
$updateSuccess = $_SESSION['updateSuccess'] ?? "";
$updateError = $_SESSION['updateError'] ?? "";
?>
<title>Profile</title>

<div class="profile-container">
    <div class="profile-section">
        <div class="profile-card" id="profileCard">
            <p>Loading profile</p>
        </div>
        
        <?php
        require_once BASE_PATH . '/includes/db.php';
        $qrImage = null;

        $result = $conn->query("SELECT file_path FROM qr_payment ORDER BY id DESC LIMIT 1");
        if ($result && $row = $result->fetch_assoc()) {
            $qrImage = BASE_URL . $row['file_path'];
        }
        ?>

        <div style="margin-top: 20px; text-align: center;">
            <h4 style="margin-bottom: 10px;">Payment QR Code</h4>

            <?php if ($qrImage): ?>
                <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                    <img src="<?= htmlspecialchars($qrImage) ?>" alt="QR Code"
                        style="width:150px; border:1px solid #ccc; border-radius:8px;">
                    <form method="POST" action="<?= BASE_URL ?>/Owner/processes/profile/upload_qr.php" enctype="multipart/form-data">
                        <input type="file" name="qrImage" accept="image/*" required style="margin-top:10px;">
                        <button type="submit" class="confirm-btn" style="width:150px; margin-top:5px;">Replace QR</button>
                    </form>
                </div>
            <?php else: ?>
                <form method="POST" action="<?= BASE_URL ?>/Owner/processes/profile/upload_qr.php" enctype="multipart/form-data">
                    <input type="file" name="qrImage" accept="image/*" required>
                    <button type="submit" class="confirm-btn" style="width:150px; margin-top:5px;">Upload QR</button>
                </form>
            <?php endif; ?>
        </div>

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
    </div>

    <div class="tabs-container-branch">
        <div class="tabs-branch">
            <div class="tab active">Branches</div>
        </div>

        <div class="branches-table">
            <table id="branchesTable" class="transaction-table"></table>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
