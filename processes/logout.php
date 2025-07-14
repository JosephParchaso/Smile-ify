<?php
session_start();
session_unset();
session_destroy();
$baseUrl = $_SERVER['HTTP_HOST'] === 'localhost' ? '/Smile-ify' : '';


header("Location: $baseUrl/index.php");
exit;
?>
