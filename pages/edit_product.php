<?php
include '../includes/db.php';
include '../includes/header.php';

// Access Control
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Get Product Data
if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php?tab=menu");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: admin_dashboard.php?tab=menu&error=Product not found");
    exit();
}
?>

<div class="container" style="max-width: 600px; padding: 4rem 0;">
    <h2 style="text-align: center; margin-bottom: 2rem;">Edit Product</h2>

    <form action="../actions/update_product_action.php" method="POST" enctype="multipart/form-data" 
          style="background: #fff; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        
        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>

        <div class="form-group">
            <label>Price (₱)</label>
            <input type="number" name="price" class="form-control" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        </div>

        <div class="form-group">
            <label>Current Image</label><br>
            <img src="../<?php echo htmlspecialchars($product['image_url']); ?>" alt="Current" style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px; margin-bottom: 10px;">
        </div>

        <div class="form-group">
            <label>Change Image (Optional)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small style="color: #777;">Leave empty to keep current image.</small>
        </div>

        <button type="submit" class="submit-btn">Update Product</button>
        <a href="admin_dashboard.php?tab=menu" class="order-btn" style="display:block; text-align:center; margin-top: 10px; background: #7f8c8d; text-decoration: none;">Cancel</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>