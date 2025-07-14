<?php
$baseUrl = $_SERVER['HTTP_HOST'] === 'localhost' ? '/Smile-ify' : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Google Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" href="<?= $baseUrl ?>/images/logo/logo_white.png" type="image/x-icon" />

    <!-- Styles -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/css/style.css?v=<?= time(); ?>" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- JavaScript -->
    <script src="<?= $baseUrl ?>/js/openBookingModal.js?v=<?= time(); ?>"></script>
    <script src="<?= $baseUrl ?>/js/togglePassword.js?v=<?= time(); ?>"></script>
    <script src="<?= $baseUrl ?>/js/loadServices.js?v=<?= time(); ?>"></script>
    <script src="<?= $baseUrl ?>/js/toggleCalendar.js?v=<?= time(); ?>"></script>
    <script src="<?= $baseUrl ?>/js/loadDentists.js?v=<?= time(); ?>"></script>
    <script src="<?= $baseUrl ?>/js/openEducationalModal.js?v=1.1"></script>
    <script src="<?= $baseUrl ?>/js/toggleNavbar.js?v=<?= time(); ?>"></script>
    <script src="<?= $baseUrl ?>/js/loadNotifications.js?v=<?= time(); ?>"></script>
    <script src="<?= $baseUrl ?>/js/logoutModal.js?v=<?= time(); ?>"></script>
</head>
