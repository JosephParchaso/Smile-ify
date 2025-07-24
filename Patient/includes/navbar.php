<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
require_once BASE_PATH . '/includes/db.php';
require_once BASE_PATH . '/processes/fetch_notifications.php';
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/Patient/css/style.css?v=<?= time(); ?>" />

<nav>
    <div class="nav-container">
        <button class="menu-toggle">&#9776;</button>
        <ul class="nav-menu">
            <li>
                <a href="<?= BASE_URL ?>/Patient/index.php" class="<?= ($currentPage == 'index') ? 'active' : '' ?>">
                    <span class="material-symbols-outlined">home</span>
                    <span class="link-text">Home</span>
                </a>
            </li>
            <li>
                <a href="<?= BASE_URL ?>/Patient/pages/schedule.php" class="<?= ($currentPage == 'schedule') ? 'active' : '' ?>">
                    <span class="material-symbols-outlined">calendar_month</span>
                    <span class="link-text">Schedules</span>
                </a>
            </li>
            <li>
                <a href="<?= BASE_URL ?>/Patient/pages/profile.php" class="<?= ($currentPage == 'profile') ? 'active' : '' ?>">
                    <span class="material-symbols-outlined">person</span>
                    <span class="link-text">Profile</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link" id="notifDropdownToggle">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="link-text">Notifications</span>
                    <?php if ($unreadCount > 0): ?>
                        <span class="notif-badge"><?= $unreadCount ?></span>
                    <?php endif; ?>
                </a>
                <div class="notif-dropdown" id="notifDropdown">
                    <h4>Notifications</h4>
                    <ul>
                        <?php if (count($notifications) === 0): ?>
                            <li class="notif-item">No notifications</li>
                        <?php else: ?>
                            <?php foreach ($notifications as $n): ?>
                                <li 
                                    class="notif-item <?= $n['is_read'] ? '' : 'unread' ?>" 
                                    data-id="<?= $n['notification_id'] ?>"
                                >
                                    <span class="notif-message"><?= htmlspecialchars($n['message']) ?></span>
                                    <span class="notif-date"><?= date('M d, H:i', strtotime($n['created_at'])) ?></span>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <a href="#" id="markAllRead">Read all notifications</a>
                </div>
            </li>
            <li>
                <a href="#" id="logoutLink">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="link-text">Logout</span>
                </a>

                <div id="logoutModal" class="logout-modal">
                    <div class="logout-modal-content">
                        <p>Are you sure you want to log out?</p>
                        <div class="modal-buttons">
                            <button id="confirmLogout">Yes, log out</button>
                            <button id="cancelLogout">Cancel</button>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
