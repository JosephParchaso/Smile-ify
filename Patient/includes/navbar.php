
<nav>
    <ul>
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
</nav>

<style>
    nav {
        background-color: #122130;
        padding: 10px 0;
    }

    nav ul {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    nav ul li {
        display: flex;
        align-items: stretch;
    }

    nav ul li a {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 10px 16px;
        color: white;
        text-decoration: none;
        font-weight: 500;
        height: 100%;
        width: 100%;
    }

    nav ul li a:hover {
        background-color: #243b53;
        transition: background-color 0.3s ease;
        border-radius: 4px;
    }

    nav ul li a.active {
        border-bottom: 2px solid #ffffff;
        padding-bottom: 4px;
    }

    .material-symbols-outlined {
        font-size: 20px;
        vertical-align: middle;
    }
</style>
