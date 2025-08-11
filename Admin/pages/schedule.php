<?php
session_start();

$currentPage = 'schedule';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Admin/includes/navbar.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}
?>
<title>Schedules</title>
<div class="calendar-container">
    <div id="calendar"></div>
</div>
<input type="hidden" id="branchIdInput" value="<?= htmlspecialchars($_SESSION['branch_id'] ?? '') ?>">

<div id="appointmentModalDetails" class="booking-modal"> 
    <div class="booking-modal-content">
        <h2>Appointment Details</h2>
        <p><strong>Patient:</strong> <span id="modalPatient"></span></p>
        <p><strong>Branch:</strong> <span id="modalBranch"></span></p>
        <p><strong>Service:</strong> <span id="modalService"></span></p>
        <p><strong>Dentist:</strong> <span id="modalDentist"></span></p>
        <p><strong>Date:</strong> <span id="modalDate"></span></p>
        <p><strong>Time:</strong> <span id="modalTime"></span></p>
    </div>
</div>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>

