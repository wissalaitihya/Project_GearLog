<?php 

$host = "127.0.0.1:3307";
$dbname = "gearlog";
$username = "root";
$password = "";
$dsn = "mysql:host=$host;dbname=$dbname";
try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully with PDO . \n";

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


?>