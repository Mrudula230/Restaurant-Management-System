<?php
// config.php : connects PHP to the MySQL database
// Every page includes this file, so the connection code is written only once.

$host     = "localhost";
$user     = "root";          // default user of XAMPP
$password = "";              // default password of XAMPP is empty
$database = "restaurant_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
