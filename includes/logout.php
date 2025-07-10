<?php
session_start();
session_unset();
session_destroy();


header("Location: /Smile-ify/index.php");
exit;
?>
