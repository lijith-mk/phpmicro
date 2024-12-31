<?php
$servername = "localhost";  // Database host (often localhost)
$username = "root";         // Database username (default in many cases)
$password = "";             // Database password (leave empty if not set)
$dbname = "contact_manager";  // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
