<?php
session_start();
$host = "127.0.0.1"; 
$port="3307";
$dbname = "gearlog";
$username = "root";
$password = "";

try {
   
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully with PDO. <br>";
} catch(PDOException $e) {
    die("connection failed" . $e->getMessage());
}

echo "<h3>All Assets</h3>";
$sql = "SELECT * FROM assets";
$stmt = $conn->prepare($sql);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Device: " . htmlspecialchars($row["device_name"]) . 
         " | Price: " . htmlspecialchars($row["price"]) . 
         " | Serial: " . htmlspecialchars($row["serial_number"]) . "<br>";
}


$serial_number = "SN" . rand(1000, 9999);
$device_name   = "Laptop"; 
$price         = "1000.00";
$status        = "Active";
$category_id   = 1;


$sql = "INSERT INTO assets (serial_number, device_name, price, status, category_id)
        VALUES (:serial, :device, :price, :status, :cat_id)";

try {
    $stmt = $conn->prepare($sql);
    
  
    $stmt->bindParam(':serial', $serial_number);
    $stmt->bindParam(':device', $device_name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':cat_id', $category_id); 
    
    $stmt->execute();
    echo "<strong>New asset created successfully!</strong><br>";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}

echo "<h4> Categories </h4>";
$sql = "SELECT * FROM categories";
$stmt = $conn->prepare($sql);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Category Name: " . htmlspecialchars($row["name"]) . "<br>";
}
?>