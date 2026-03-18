<?php
$host = "127.0.0.1";
$port = "3307"; 
$dbname = "gearlog";
$username = "root";
$pasword = "";

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $conn = new PDO($dsn, $username, $pasword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    die("Database Connection Error: " . $e->getMessage());
}
?>