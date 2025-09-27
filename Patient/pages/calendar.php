<?php
session_start();

$currentPage = 'calendar';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    session_unset();
    session_destroy();
    header("Location: " . BASE_URL . "/index.php");
    exit();
}
require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Patient/includes/navbar.php';
$updateSuccess = $_SESSION['updateSuccess'] ?? "";
$updateError = $_SESSION['updateError'] ?? "";
?>
<title>My Schedule</title>

<div class="calendar-container">
    <div id="calendarLegend" class="legend"></div>
    <div id="calendar"></div>
</div>

<div id="appointmentModalDetails" class="manage-appointment-modal">
    <div class="manage-appointment-modal-content">
        <div id="modalBody" class="manage-appointment-modal-content-body">
            <!-- Appointment info will be loaded here -->
        </div>
    </div>
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

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
