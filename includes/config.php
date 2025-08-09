<?php
date_default_timezone_set('Asia/Manila');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$baseUrl = (strpos($_SERVER['REQUEST_URI'], '/Smile-ify') !== false || $_SERVER['HTTP_HOST'] === 'localhost') ? '/Smile-ify' : '';
define('BASE_URL', $baseUrl);
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . BASE_URL);
?>
