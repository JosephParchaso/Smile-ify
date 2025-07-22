<?php
session_start();
$currentPage = 'schedule';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/Patient/includes/navbar.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /Smile-ify/index.php");
    exit();
}
?>
<title>My Schedule</title>

<div class="calendar-container">
    <div id="calendar"></div>
</div>

<div id="appointmentModalDetails" class="booking-modal"> 
    <div class="booking-modal-content">
        <h2>Appointment Details</h2>
        <p><strong>Branch:</strong> <span id="modalBranch"></span></p>
        <p><strong>Service:</strong> <span id="modalService"></span></p>
        <p><strong>Dentist:</strong> <span id="modalDentist"></span></p>
        <p><strong>Date:</strong> <span id="modalDate"></span></p>
        <p><strong>Time:</strong> <span id="modalTime"></span></p>
    </div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/footer.php'; ?>
