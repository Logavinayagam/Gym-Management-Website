<?php
// Database credentials
$host = 'localhost';
$db   = 'gym_management'; // Change this to your database name
$user = 'root';           // XAMPP default username is 'root'
$pass = '';               // XAMPP default password is empty
$port = '4306';           // Specify your MySQL port

try {
    // Create a PDO instance with the correct port
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
    
    // Set error mode to Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Handle connection errors
    die("Database connection failed: " . $e->getMessage());
}
?>
