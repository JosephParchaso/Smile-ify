<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$role = $_SESSION['role'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" href="<?= BASE_URL ?>/images/logo/logo_white.png" type="image/x-icon" />

    <!-- Global Styles -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css?v=<?= time(); ?>" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- JS: All users -->
    <script src="<?= BASE_URL ?>/js/openBookingModal.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE_URL ?>/js/openForgotPasswordModal.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE_URL ?>/js/togglePassword.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE_URL ?>/js/loadServices.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE_URL ?>/js/toggleCalendar.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE_URL ?>/js/loadDentists.js?v=<?= time(); ?>"></script>

    <!-- JS: Authenticated users -->
    <script src="<?= BASE_URL ?>/js/toggleNavbar.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE_URL ?>/js/loadNotifications.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE_URL ?>/js/switchTab.js?v=<?= time(); ?>"></script>

    <?php if ($role === 'owner'): ?>
        <!-- Owner-specific -->
        <script src="<?= BASE_URL ?>/js/Owner/loadAppointmentSchedule.js?v=<?= time(); ?>"></script>
        <script src="<?= BASE_URL ?>/js/Owner/loadProfileDetails.js?v=<?= time(); ?>"></script>

    <?php elseif ($role === 'admin'): ?>
        <!-- Admin-specific -->
        <script src="<?= BASE_URL ?>/js/Admin/loadAppointmentSchedule.js?v=<?= time(); ?>"></script>
        <script src="<?= BASE_URL ?>/js/Admin/loadProfileDetails.js?v=<?= time(); ?>"></script>

    <?php elseif ($role === 'patient'): ?>
        <!-- Patient-specific -->
        <script src="<?= BASE_URL ?>/js/Patient/loadAppointmentSchedule.js?v=<?= time(); ?>"></script>
        <script src="<?= BASE_URL ?>/js/Patient/loadProfileDetails.js?v=<?= time(); ?>"></script>
        <script src="<?= BASE_URL ?>/js/Patient/loadAppointments.js?v=<?= time(); ?>"></script>
    <?php endif; ?>

    <!-- JS: Extras -->
    <script src="<?= BASE_URL ?>/js/openEducationalModal.js?v=1.1"></script>
    <script src="<?= BASE_URL ?>/js/logoutModal.js?v=<?= time(); ?>"></script>

    <!-- PHP constant to JS -->
    <script>
        const BASE_URL = "<?= BASE_URL ?>";
    </script>
</head>
