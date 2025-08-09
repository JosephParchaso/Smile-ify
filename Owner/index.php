<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

$currentPage = 'index';

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Owner/includes/navbar.php';
?>

<div class="dashboard">

    <div class="cards">
        
        <div class="card">
            <h2><span class="material-symbols-outlined">monitoring</span> Revenue This Month</h2>
            <div class="appointment">₱ ---</div>
            <div class="appointment">Change vs last month: ---%</div>
        </div>

        <div class="card">
            <h2><span class="material-symbols-outlined">calendar_month</span> Appointments Overview</h2>
            <div class="appointment">Today: ---</div>
            <div class="appointment">This Month: ---</div>
        </div>

        <div class="card">
            <h2><span class="material-symbols-outlined">groups</span> Employees</h2>
            <div class="announcement">Active: ---</div>
            <div class="announcement">On Leave: ---</div>
        </div>

        <div class="card">
            <h2><span class="material-symbols-outlined">notifications</span> Recent Notifications</h2>

            <?php if (empty($notifications)): ?>
                <div class="announcement">No notifications</div>
            <?php else: ?>
                <?php foreach (array_slice($notifications, 0, 3) as $n): ?>
                    <div class="announcement <?= $n['is_read'] ? '' : 'unread' ?>">
                        <div class="notif-message"><?= htmlspecialchars($n['message']) ?></div>
                        <div class="notif-date"><?= date('M d, Y H:i', strtotime($n['created_at'])) ?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="card">
            <h2><span class="material-symbols-outlined">apartment</span> Branch Performance</h2>
            <div class="appointment">Mandaue: ---</div>
            <div class="appointment">Pusok: ---</div>
            <div class="appointment">Babag: ---</div>
        </div>

        <div class="card">
            <h2><span class="material-symbols-outlined">bolt</span> Quick Links</h2>
            <div class="quick-links">
                <a href="<?= BASE_URL ?>/Owner/pages/reports.php" ><span class="material-symbols-outlined">finance</span> Reports</a>
                <a href="<?= BASE_URL ?>/Owner/pages/employees.php"><span class="material-symbols-outlined">groups</span> Manage Employees</a>
                <a href="<?= BASE_URL ?>/Owner/pages/profile.php"><span class="material-symbols-outlined">manage_accounts</span> Profile Settings</a>
            </div>
        </div>

    </div>
</div>


<?php require_once BASE_PATH . '/includes/footer.php'; ?>
