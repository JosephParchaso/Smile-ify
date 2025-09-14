<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    session_unset();
    session_destroy();
    header("Location: " . BASE_URL . "/index.php");
    exit();
}

$currentPage = 'index';

require_once BASE_PATH . '/includes/header.php';
require_once BASE_PATH . '/Admin/includes/navbar.php';

$todayCount     = 5;
$tomorrowCount  = 3;
$newPatients    = 12;
$totalPatients  = 230;
$lowSupplies    = [
    ['name' => 'Dental Gloves', 'quantity' => 15],
    ['name' => 'Anesthetic', 'quantity' => 5],
    ['name' => 'Face Masks', 'quantity' => 20],
];
$monthlyRevenue = "₱120,000";
$totalAppointmentsMonth = 42;
?>

<title>Home</title>

<div class="dashboard">
    <div class="cards">

        <div class="card">
            <h2><span class="material-symbols-outlined">calendar_month</span> Today's Appointments</h2>
            <div class="appointment">Today: <?= $todayCount ?></div>
            <div class="appointment">Tomorrow: <?= $tomorrowCount ?></div>
            <a href="<?= BASE_URL ?>/Admin/pages/calendar.php" class="card-link">View Schedule</a>
            <a href="<?= BASE_URL ?>/Admin/pages/add_appointment.php" class="card-link">Add Appointment</a>
        </div>

        <div class="card">
            <h2><span class="material-symbols-outlined">bar_chart</span> Reports</h2>
            <div class="appointment">Monthly Revenue: <?= $monthlyRevenue ?></div>
            <div class="appointment">Appointments this Month: <?= $totalAppointmentsMonth ?></div>
            <a href="<?= BASE_URL ?>/Admin/pages/reports.php" class="card-link">View Detailed Reports</a>
        </div>

        <div class="card">
            <h2><span class="material-symbols-outlined">groups</span> Patients</h2>
            <div class="appointment">New This Month: <?= $newPatients ?></div>
            <div class="appointment">Total: <?= $totalPatients ?></div>
            <a href="<?= BASE_URL ?>/Admin/pages/patients.php" class="card-link">Manage Patients</a>
        </div>

        <div class="card">
            <h2><span class="material-symbols-outlined">inventory_2</span> Supplies</h2>
            <?php if (empty($lowSupplies)): ?>
                <div class="announcement">All supplies stocked</div>
            <?php else: ?>
                <?php foreach ($lowSupplies as $s): ?>
                    <div class="announcement"><?= htmlspecialchars($s['name']) ?> - <?= $s['quantity'] ?> left</div>
                <?php endforeach; ?>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/Admin/pages/supplies.php" class="card-link">Manage Supplies</a>
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
            <h2><span class="material-symbols-outlined">bolt</span> Quick Links</h2>
            <div class="quick-links">
                <a href="<?= BASE_URL ?>/Admin/pages/services.php"><span class="material-symbols-outlined">medical_services</span> Manage Services</a>
                <a href="<?= BASE_URL ?>/Admin/pages/promos.php"><span class="material-symbols-outlined">local_offer</span> Manage Promos</a>
                <a href="<?= BASE_URL ?>/Admin/pages/profile.php"><span class="material-symbols-outlined">contact_emergency</span> View Doctors</a>
                <a href="<?= BASE_URL ?>/Admin/pages/profile.php"><span class="material-symbols-outlined">manage_accounts</span> Profile Settings</a>
            </div>
        </div>

    </div>
</div>

<?php require_once BASE_PATH . '/includes/footer.php'; ?>
