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
?>
<title>Reports</title>

<div class="tabs-container">
    <div class="tabs">
        <div class="tab active" onclick="switchTab('babag')">Babag</div>
        <div class="tab" onclick="switchTab('pusok')">Pusok</div>
        <div class="tab" onclick="switchTab('mandaue')">Mandaue</div>
    </div>

    <div class="tab-content active" id="babag">

    </div>

    <div class="tab-content" id="pusok">
        
    </div> 

    <div class="tab-content" id="mandaue">
        
    </div>
</div>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
