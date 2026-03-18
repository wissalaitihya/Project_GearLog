<?php 
session_start();
$host = "127.0.0.1";
$port = "3307";
$dbname = "gearlog";
$username = "root";
$pasword = "";
$dsn = "mysql:host=$host;dbname=$dbname";
try {
    $conn = new PDO($dsn, $username, $pasword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully with PDO . \n";

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


?>