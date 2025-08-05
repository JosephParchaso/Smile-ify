<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Smile-ify/includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <link rel="icon" href="<?= BASE_URL ?>/images/logo/logo_white.png" type="image/x-icon" />

    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css?v=<?= time(); ?>" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    
    <script src="<?= BASE_URL ?>/js/openBookingModal.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE_URL ?>/js/openForgotPasswordModal.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE_URL ?>/js/togglePassword.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE_URL ?>/js/loadServices.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE_URL ?>/js/toggleCalendar.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE_URL ?>/js/loadDentists.js?v=<?= time(); ?>"></script>
    
    <script src="<?= BASE_URL ?>/js/toggleNavbar.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE_URL ?>/js/loadNotifications.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE_URL ?>/js/switchTab.js?v=<?= time(); ?>"></script>

    <script src="<?= BASE_URL ?>/js/loadAppointmentDetails.js?v=<?= time(); ?>"></script>
    <script src="<?= BASE_URL ?>/js/loadProfileDetails.js?v=<?= time(); ?>"></script>

    <script src="<?= BASE_URL ?>/js/openEducationalModal.js?v=1.1"></script>
    <script src="<?= BASE_URL ?>/js/logoutModal.js?v=<?= time(); ?>"></script>

    <script>
        const BASE_URL = "<?= BASE_URL ?>";
    </script>
</head>
