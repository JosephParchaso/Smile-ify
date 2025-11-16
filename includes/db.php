<?php
$servername = "localhost";
$username = "root"; // s18100807_smileifytest || root
$password = ""; // P@ssw0rd
$dbname = "smile-ify"; // s18100807_smileifytest || smile-ify

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}  
?>  