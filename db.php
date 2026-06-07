<?php
// Database connection settings
$host = 'localhost'; 
$db = 'intelli_host'; 
$username = 'root'; 
$password = ''; 
$port = 3307; 

try {
    
    $pdo = new PDO("mysql:host=$host;dbname=$db;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>
