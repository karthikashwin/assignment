<?php
$servername = "localhost:3306"; // Replace with your MySQL hostname
$username = "root"; // Replace with your MySQL username
$password = "Ashwin@2002"; // Replace with your MySQL password
$dbname = "practice"; // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>