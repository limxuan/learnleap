<?php
// Database credentials
$servername = "localhost";  // Your server, usually localhost
$username = "username";         // Default XAMPP MySQL username
$password = "password";             // Default XAMPP MySQL password (empty by default)
$dbname = "testdb";         // Name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// Close connection
$conn->close();
?>
