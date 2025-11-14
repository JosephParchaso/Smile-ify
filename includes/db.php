<?php
$servername = "localhost";
$username = "root"; //s18100807_smileify || root
$password = ""; //P@ssw0rdsmile
$dbname = "smile-ify"; //smile_ify_nodata || smile-ify || s18100807_smileify

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}  
?>  