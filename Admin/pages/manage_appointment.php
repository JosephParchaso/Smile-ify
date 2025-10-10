<?php
session_start();

$currentPage = 'patients';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    session_unset();
    session_destroy();
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Admin/includes/navbar.php';

$appointmentId = $_GET['id'] ?? null;
if (!$appointmentId) {
    echo "<p>No appointment selected.</p>";
    require_once BASE_PATH . '/includes/footer.php';
    exit();
}
$updateSuccess = $_SESSION['updateSuccess'] ?? "";
$updateError   = $_SESSION['updateError'] ?? "";

$backTab = $_GET['backTab'] ?? 'recent';

$validTabs = ['dental_transactions', 'vitals', 'prescriptions'];
$activeTab = in_array($_GET['tab'] ?? '', $validTabs) ? $_GET['tab'] : 'dental_transactions';
?>
<title>Appointment Details</title>

<div class="profile-container">
    <div class="profile-section">

        <div class="back-button-container">
            <a href="<?= BASE_URL ?>/Admin/pages/patients.php?tab=<?= htmlspecialchars($backTab) ?>" class="back-button-icon">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
        </div>
        
        <div class="profile-card" id="appointmentCard">
            <p>Loading profile</p>
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

    <div class="tabs-container">
        <div class="tabs-patient">
            <div class="tab <?= $activeTab === 'dental_transactions' ? 'active' : '' ?>" onclick="switchTab('dental_transactions')">Transaction</div>
            <div class="tab <?= $activeTab === 'vitals' ? 'active' : '' ?>" onclick="switchTab('vitals')">Vitals</div>
            <div class="tab <?= $activeTab === 'prescriptions' ? 'active' : '' ?>" onclick="switchTab('prescriptions')">Prescriptions</div>
        </div> 
        
        <div class="tab-content <?= $activeTab === 'dental_transactions' ? 'active' : '' ?>" id="dental_transactions">
            <table id="dentaltransactionTable" class="transaction-table">
            </table>
        </div>

        <div class="tab-content <?= $activeTab === 'vitals' ? 'active' : '' ?>" id="vitals">
            <table id="vitalTable" class="transaction-table">
            </table>
        </div>

        <div class="tab-content <?= $activeTab === 'prescriptions' ? 'active' : '' ?>" id="prescriptions">
            <table id="prescriptionTable" class="transaction-table">
            </table>
        </div>
    </div>

    <div id="manageRecordModal" class="manage-appointment-modal">
        <div class="manage-appointment-modal-content">
            <div id="modalRecordBody" class="manage-appointment-modal-content-body">
                <!-- Vitals info will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
    const appointmentId = "<?= htmlspecialchars($appointmentId) ?>";
    const branchId = "<?= htmlspecialchars($branch_id ?? '') ?>";
</script>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>

