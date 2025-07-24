<?php
$baseUrl = (strpos($_SERVER['REQUEST_URI'], '/Smile-ify') !== false || $_SERVER['HTTP_HOST'] === 'localhost') ? '/Smile-ify' : '';
define('BASE_URL', $baseUrl);
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . BASE_URL);


?>