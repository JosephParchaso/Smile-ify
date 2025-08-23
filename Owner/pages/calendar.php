<?php
session_start();

$currentPage = 'calendar';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    session_unset();
    session_destroy();
    header("Location: " . BASE_URL . "/index.php");
    exit();
}
require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Owner/includes/navbar.php';
?>
<title>Schedules</title>

<div class="calendar-container">
    <div id="calendar"></div>
</div>

<div id="appointmentModalDetails" class="booking-modal"> 
    <div class="booking-modal-content">
        <h2>Appointment Details</h2>
        <p><strong>Patient:</strong> <span id="modalPatient"></span></p>
        <p><strong>Branch:</strong> <span id="modalBranch"></span></p>
        <p><strong>Service:</strong> <span id="modalService"></span></p>
        <p><strong>Dentist:</strong> <span id="modalDentist"></span></p>
        <p><strong>Date:</strong> <span id="modalDate"></span></p>
        <p><strong>Time:</strong> <span id="modalTime"></span></p>
        <p><strong>Notes:</strong> <span id="modalNotes"></span></p>
    </div>
</div>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
