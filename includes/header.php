<?php
$basePath = '/Smile-ify';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <link rel="icon" href="<?= $basePath ?>/images/logo/logo_white.png" type="image/x-icon">
    <link rel="stylesheet" href="<?= $basePath ?>/css/style.css?v=<?= time(); ?>">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="<?= $basePath ?>/js/openBookingModal.js"></script>
    <script src="<?= $basePath ?>/js/togglePassword.js"></script>
    <script src="<?= $basePath ?>/js/loadServices.js"></script>
    <script src="<?= $basePath ?>/js/toggleCalendar.js"></script>
    <script src="<?= $basePath ?>/js/loadDentists.js"></script>
    <script src="<?= $basePath ?>/js/openEducationalModal.js?v=1.1"></script>
    <script src="<?= $basePath ?>/js/toggleNavbar.js?v=<?= time(); ?>"></script>
    <script src="<?= $basePath ?>/js/logoutModal.js?v=<?= time(); ?>"></script>
</head>
