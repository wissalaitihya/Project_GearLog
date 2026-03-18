<?php
require_once 'config/db.php'; 
session_start();

$message = "";
$messageType = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serial = $_POST['serial_number'];
    $device = $_POST['device_name'];
    $price  = $_POST['price'];
    $status = $_POST['status'];
    $cat_id = $_POST['category_id'];

    
    $sql = "INSERT INTO assets (serial_number, device_name, price, status, category_id) 
            VALUES (:serial, :device, :price, :status, :cat_id)";
    
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':serial' => $serial,
            ':device' => $device,
            ':price'  => $price,
            ':status' => $status,
            ':cat_id' => $cat_id
        ]);
        $message = "Asset successfully added!";
        $messageType = "success";
    } catch (PDOException $e) {
       
        $message = "Error: " . $e->getMessage();
        $messageType = "danger";
    }
}

$catStmt = $conn->query("SELECT * FROM categories");

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">➕ Add New Asset</h4>
            </div>
            <div class="card-body">
                
                <?php if(!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show">
                    <?php echo htmlspecialchars($message); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <form method="POST" action="add_asset.php">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Serial Number *</label>
                            <input type="text" class="form-control" name="serial_number" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Device Name *</label>
                            <input type="text" class="form-control" name="device_name" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Category *</label>
                            <select class="form-select" name="category_id" required>
                                <option value="" disabled selected>Select Category...</option>
                                <?php while ($cat = $catStmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <option value="<?php echo $cat['id']; ?>">
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Price ($) *</label>
                            <input type="number" step="0.01" class="form-control" name="price" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Status *</label>
                            <select class="form-select" name="status" required>
                                <option value="In Storage" selected>In Storage</option>
                                <option value="Deployed">Deployed</option>
                                <option value="Under Repair">Under Repair</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Save Asset Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>