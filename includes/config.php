<?php
date_default_timezone_set('Asia/Manila');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$baseUrl = (strpos($_SERVER['REQUEST_URI'], '/Smile-ify') !== false || $_SERVER['HTTP_HOST'] === 'localhost') ? '/Smile-ify' : '';
define('BASE_URL', $baseUrl);
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . BASE_URL);

$timeout_duration = 1800; // change to 1800 for 30 mins

if (isset($_SESSION['LAST_ACTIVITY']) && 
    (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    
    session_unset();
    session_destroy();

    session_start();
    $_SESSION['timeoutError'] = "Your session has expired due to inactivity. Please log in again.";

    header("Location: " . BASE_URL . "/index.php");
    exit();
}

$_SESSION['LAST_ACTIVITY'] = time();
?>
