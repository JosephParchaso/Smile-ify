<nav>
    <div class="nav-container">
        <button class="menu-toggle">&#9776;</button>
        <ul class="nav-menu">
            <li>
                <a href="/Smile-ify/Patient/index.php" class="<?= ($currentPage == 'index') ? 'active' : '' ?>">
                <span class="material-symbols-outlined">home</span>
                <span class="link-text">Home</span>
                </a>
            </li>
            <li>
                <a href="/Smile-ify/Patient/pages/schedule.php" class="<?= ($currentPage == 'schedule') ? 'active' : '' ?>">
                <span class="material-symbols-outlined">calendar_month</span>
                <span class="link-text">Schedules</span>
                </a>
            </li>
            <li>
                <a href="/Smile-ify/Patient/pages/profile.php" class="<?= ($currentPage == 'profile') ? 'active' : '' ?>">
                <span class="material-symbols-outlined">person</span>
                <span class="link-text">Profile</span>
                </a>
            </li>
            <li>
                <a href="/Smile-ify/Patient/pages/about.php" class="<?= ($currentPage == 'about') ? 'active' : '' ?>">
                <span class="material-symbols-outlined">info</span>
                <span class="link-text">About</span>
                </a>
            </li>
            <li>
                <a href="/Smile-ify/Patient/pages/notifications.php" class="<?= ($currentPage == 'notifications') ? 'active' : '' ?>">
                <span class="material-symbols-outlined">notifications</span>
                <span class="link-text">Notifications</span>
                </a>
            </li>
            <li>
                <a href="/Smile-ify/Patient/pages/logout.php" class="<?= ($currentPage == 'logout') ? 'active' : '' ?>">
                <span class="material-symbols-outlined">logout</span>
                <span class="link-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</nav>