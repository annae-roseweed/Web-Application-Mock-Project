<?php
$host = "localhost";
$dbname = "socialnet";
$dbuser = "annae";
$dbpass = "password123";

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
