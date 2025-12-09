<?php
include '../includes/db.php';
// Check if user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php?error=Admin access required");
    exit();
}
include '../includes/header.php';

// Fetch all products for display
$products = [];
try {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle error gracefully
    $fetch_error = "Could not load products: " . $e->getMessage();
}

// Get current tab from URL, default to menu
$tab = $_GET['tab'] ?? 'menu'; 
?>

<div class="admin-container">
    <div class="admin-header">
        <h2>Admin Dashboard</h2>
        <div>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?> (Admin)</div>
    </div>

    <div class="tab-nav" style="margin-bottom: 2rem;">
        <a href="?tab=menu" class="order-btn" style="background-color: <?php echo ($tab == 'menu') ? 'var(--primary-color)' : '#ccc'; ?>;">Manage Menu</a>
        <a href="?tab=orders" class="order-btn" style="background-color: <?php echo ($tab == 'orders') ? 'var(--primary-color)' : '#ccc'; ?>;">View Orders</a>
        <a href="?tab=users" class="order-btn" style="background-color: <?php echo ($tab == 'users') ? 'var(--primary-color)' : '#ccc'; ?>;">Manage Users</a>
    </div>

    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php elseif(isset($_GET['success'])): ?>
        <div class="alert" style="background-color: var(--success); color: white;"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>
    <?php if(isset($fetch_error)): ?>
        <div class="alert alert-error"><?php echo $fetch_error; ?></div>
    <?php endif; ?>


    <div class="admin-content">
        <?php if($tab == 'menu'): ?>
            <div class="product-form-card">
                <h3>Add New Menu Item</h3>
                <form action="../actions/add_product_action.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Price (₱)</label>
                        <input type="number" name="price" class="form-control" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label>Product Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" class="order-btn">Add Product</button>
                </form>
            </div>

            <hr style="margin: 2rem 0;">
            
            <div class="product-table-wrapper">
                <h3>Current Menu Items</h3>
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $product): ?>
                        <tr>
                            <td><img src="../<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>"></td>
                            <td><?php echo htmlspecialchars($product['id']); ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td>₱<?php echo htmlspecialchars(number_format($product['price'], 2)); ?></td>
                            <td class="action-buttons">
                                <a href="edit_product.php?id=<?php echo $product['id']; ?>" title="Edit"><i class="material-icons">edit</i></a>
                                
                                <form method="GET" action="../actions/delete_product_action.php" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                    <button type="submit" title="Delete"><i class="material-icons">delete</i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($products)): ?>
                            <tr><td colspan="5" style="text-align: center;">No menu items found. Please add some!</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        <?php elseif($tab == 'orders'): ?>
            <h3 style="padding: 50px; text-align: center;">View Orders functionality coming soon...</h3>

        <?php elseif($tab == 'users'): ?>
            <h3 style="padding: 50px; text-align: center;">Manage Users functionality coming soon...</h3>

        <?php endif; ?>
    </div>
</div>

</body>
</html>