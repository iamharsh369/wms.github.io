<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname ='inventory';

// Connecting to database.
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Log the error message or display it
    echo 'Connection failed: ' . $e->getMessage();
}
?>
