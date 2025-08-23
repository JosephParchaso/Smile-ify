<?php
session_start();

$currentPage = 'employees';
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
<title>Employees</title>

<div class="tabs-container">
    <div class="tabs">
        <div class="tab active" onclick="switchTab('admin')">Admins</div>
        <div class="tab" onclick="switchTab('dentist')">Dentists</div>
    </div>

    <div class="tab-content active" id="admin">
        <table id="adminsTable" class="transaction-table">
        </table>
    </div>

    <div class="tab-content" id="dentist">
        <table id="dentistsTable" class="transaction-table">
        </table>
    </div>
</div>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
