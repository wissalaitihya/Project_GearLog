<?php
require_once 'config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
} 

$search = isset($_GET['search']) ? $_GET['search'] : '';


$valQuery = "SELECT SUM(price) as total FROM assets";
$valStmt = $conn->prepare($valQuery);
$valStmt->execute();
$valRow = $valStmt->fetch(PDO::FETCH_ASSOC);
$totalValue = $valRow['total'] ? $valRow['total'] : 0;

$query = "SELECT a.*, c.name as category_name 
          FROM assets a
          INNER JOIN categories c ON a.category_id = c.id";

if (!empty($search)) {
    $query .= " WHERE a.device_name LIKE :search OR a.serial_number LIKE :search";
}
$query .= " ORDER BY a.created_at DESC";

$stmt = $conn->prepare($query);
if (!empty($search)) {
    $searchTerm = "%$search%";
    $stmt->bindParam(':search', $searchTerm);
}
$stmt->execute();

include 'includes/header.php';
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-4"><h2>Dashboard</h2></div>
    <div class="col-md-4 text-center">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6>Total Value</h6>
                <h4>$<?php echo number_format($totalValue, 2); ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <form class="d-flex" method="GET">
            <input class="form-control me-2" type="search" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-primary" type="submit">Search</button>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <table class="table table-hover">
        <thead class="table-dark">
    <tr>
        <th>S/N</th>
        <th>Device</th>
        <th>Category</th>
        <th>Price</th>
        <th>Status</th>
        <th>Actions</th> </tr>
</thead>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['serial_number']); ?></td>
        <td><?php echo htmlspecialchars($row['device_name']); ?></td>
        <td><?php echo htmlspecialchars($row['category_name']); ?></td>
        <td>$<?php echo number_format($row['price'], 2); ?></td>
        <td>
            <span class="badge bg-primary"><?php echo htmlspecialchars($row['status']); ?></span>
        </td>
        <td>
            <a href="delete_asset.php?id=<?php echo $row['id']; ?>" 
               class="btn btn-sm btn-danger" 
               onclick="return confirm('Are you sure you want to delete this?')">Delete</a>
        </td>
    </tr>
<?php endwhile; ?>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
