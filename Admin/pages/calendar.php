<?php
session_start();

$currentPage = 'calendar';
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
<title>Schedules</title>
<div class="calendar-container">
    <div id="calendar"></div>
</div>
<input type="hidden" id="branchIdInput" value="<?= htmlspecialchars($_SESSION['branch_id'] ?? '') ?>">

<div id="appointmentModalDetails" class="manage-appointment-modal">
    <div class="manage-appointment-modal-content">
        <div id="modalBody" class="manage-appointment-modal-content-body">
            <!-- Appointment info will be loaded here -->
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>

