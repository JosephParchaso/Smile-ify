<nav>
    <div class="nav-container">
        <button class="menu-toggle">&#9776;</button>
        <ul class="nav-menu">
            <li>
                <a href="/Smile-ify/Admin/index.php" class="<?= ($currentPage == 'index') ? 'active' : '' ?>">
                    <span class="material-symbols-outlined">home</span>
                    <span class="link-text">Home</span>
                </a>
            </li>
            <li>
                <a href="/Smile-ify/Admin/pages/schedule.php" class="<?= ($currentPage == 'schedule') ? 'active' : '' ?>">
                    <span class="material-symbols-outlined">calendar_month</span>
                    <span class="link-text">Schedules</span>
                </a>
            </li>
            <li>
                <a href="/Smile-ify/Admin/pages/patients.php" class="<?= ($currentPage == 'patients') ? 'active' : '' ?>">
                    <span class="material-symbols-outlined">groups</span>
                    <span class="link-text">Patients</span>
                </a>
            </li>
            <li>
                <a href="/Smile-ify/Admin/pages/supplies.php" class="<?= ($currentPage == 'supplies') ? 'active' : '' ?>">
                    <span class="material-symbols-outlined">inventory_2</span>
                    <span class="link-text">Supplies</span>
                </a>
            </li>
            <li>
                <a href="/Smile-ify/Admin/pages/services.php" class="<?= ($currentPage == 'services') ? 'active' : '' ?>">
                    <span class="material-symbols-outlined">medical_services</span>
                    <span class="link-text">Services</span>
                </a>
            </li>
            <li>
                <a href="/Smile-ify/Admin/pages/promos.php" class="<?= ($currentPage == 'promos') ? 'active' : '' ?>">
                    <span class="material-symbols-outlined">sell</span>
                    <span class="link-text">Promos</span>
                </a>
            </li>
            <li>
                <a href="/Smile-ify/Admin/pages/profile.php" class="<?= ($currentPage == 'profile') ? 'active' : '' ?>">
                    <span class="material-symbols-outlined">person</span>
                    <span class="link-text">Profile</span>
                </a>
            </li>
            <li>
                <a href="/Smile-ify/Admin/pages/about.php" class="<?= ($currentPage == 'about') ? 'active' : '' ?>">
                    <span class="material-symbols-outlined">info</span>
                    <span class="link-text">About</span>
                </a>
            </li>
            <li>
                <a href="/Smile-ify/Admin/pages/notifications.php" class="<?= ($currentPage == 'notifications') ? 'active' : '' ?>">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="link-text">Notifications</span>
                </a>
            </li>
            <li>
                <a href="/Smile-ify/Admin/pages/logout.php" class="<?= ($currentPage == 'logout') ? 'active' : '' ?>">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="link-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.querySelector('.menu-toggle');
    const menu = document.querySelector('.nav-menu');

    toggle.addEventListener('click', () => {
        menu.classList.toggle('show');
    });
});
</script>
