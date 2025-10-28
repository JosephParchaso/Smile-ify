<?php
$servername = "localhost";
$username = "root"; //s18100807_smileify
$password = ""; //P@ssw0rdsmile
$dbname = "smile-ify"; //s18100807_smileify

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
