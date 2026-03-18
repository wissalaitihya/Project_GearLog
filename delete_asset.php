<?php
require_once 'config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM assets WHERE id = :id";
    
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        
    
        header("Location: index.php?message=deleted");
        exit();
    } catch (PDOException $e) {
        die("Error deleting record " . $e->getMessage());
    }
}
?>