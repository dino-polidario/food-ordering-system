<?php
include '../includes/db.php';
// Check if user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php?error=Admin access required");
    exit();
}
include '../includes/header.php';

// Get current tab from URL, default to menu
$tab = $_GET['tab'] ?? 'menu';

// Helper function (needed again here)
function get_status_class($status)
{
    switch ($status) {
        case 'completed':
            return 'status-completed';
        case 'cancelled':
            return 'status-cancelled';
        default:
            return 'status-pending';
    }
}

// --- Data Fetching Logic ---

// Fetch products for 'menu' tab
$products = [];
$fetch_error_products = '';
if ($tab == 'menu') {
    try {
        $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $fetch_error_products = "Could not load products: " . $e->getMessage();
    }
}

// Fetch all orders for 'orders' tab
$orders = [];
$fetch_error_orders = '';
if ($tab == 'orders') {
    try {
        $sql = "
            SELECT 
                o.id, o.total_amount, o.status, o.created_at,
                u.full_name, u.email
            FROM orders o
            JOIN users u ON o.user_id = u.id
            ORDER BY o.created_at DESC
        ";
        $stmt = $pdo->query($sql);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $fetch_error_orders = "Could not load all orders: " . $e->getMessage();
    }
}

// Fetch all customers for 'users' tab
$customers = [];
$fetch_error_users = '';
if ($tab == 'users') {
    try {
        // Only fetch customer accounts (role != admin)
        $stmt = $pdo->prepare("SELECT id, full_name, email, created_at FROM users WHERE role = 'customer' ORDER BY created_at DESC");
        $stmt->execute();
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $fetch_error_users = "Could not load user list: " . $e->getMessage();
    }
}
?>

<link rel="stylesheet" href="../assets/css/admin.css">
<script src="../assets/js/dashboard.js"></script>
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

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php elseif (isset($_GET['success'])): ?>
        <div class="alert" style="background-color: var(--success); color: white;"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>


    <div class="admin-content">

        <?php if ($tab == 'menu'): ?>
            <div class="product-form-card">
                <h3>Add New Menu Item</h3>
                <?php if (isset($fetch_error_products)): ?><div class="alert alert-error"><?php echo $fetch_error_products; ?></div><?php endif; ?>
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
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><img src="../<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>"></td>
                                <td><?php echo htmlspecialchars($product['id']); ?></td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td>₱<?php echo htmlspecialchars(number_format($product['price'], 2)); ?></td>
                                <td class="action-buttons">
                                    <a href="edit_product.php?id=<?php echo $product['id']; ?>" title="Edit" style="color: var(--primary-color); margin-right: 10px;">
                                        <i class="material-icons">edit</i>
                                    </a>

                                    <form method="POST" action="../actions/delete_product_action.php" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

                                        <button type="submit" title="Delete" style="background:none; border:none; color: #c0392b; cursor:pointer;">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center;">No menu items found. Please add some!</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>


        <?php elseif ($tab == 'orders'): ?>
            <h3>All Customer Orders</h3>

            <?php if (isset($fetch_error_orders)): ?>
                <div class="alert alert-error"><?php echo $fetch_error_orders; ?></div>
            <?php elseif (empty($orders)): ?>
                <p style="padding: 30px; text-align: center; background: white; border-radius: 8px; margin-top: 20px;">
                    No orders have been placed yet.
                </p>
            <?php else: ?>
                <div class="product-table-wrapper">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Total (₱)</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>#<?php echo htmlspecialchars($order['id']); ?></td>
                                    <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($order['email']); ?></td>
                                    <td><?php echo date('M d, Y H:i', strtotime($order['created_at'])); ?></td>
                                    <td>₱<?php echo htmlspecialchars(number_format($order['total_amount'], 2)); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo get_status_class($order['status']); ?>">
                                            <?php echo htmlspecialchars(ucfirst($order['status'])); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <form action="../actions/update_order_status_action.php" method="POST" style="display: flex; flex-direction: column; gap: 5px;">
                                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                            <select name="new_status" class="form-control" style="width: 100%; padding: 5px;">
                                                <option value="pending" <?php echo ($order['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                                <option value="completed" <?php echo ($order['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                                <option value="cancelled" <?php echo ($order['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                            <button type="submit" class="order-btn" style="padding: 5px 10px; font-size: 0.8rem;">Update Status</button>
                                        </form>
                                        <button class="order-btn" style="padding: 5px 10px; font-size: 0.8rem; margin-top: 5px; width: 100%;" onclick="showOrderDetails(<?php echo $order['id']; ?>)">View Details</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>


        <?php elseif ($tab == 'users'): ?>
            <h3>Manage Customers</h3>

            <?php if (isset($fetch_error_users)): ?>
                <div class="alert alert-error"><?php echo $fetch_error_users; ?></div>
            <?php elseif (empty($customers)): ?>
                <p style="padding: 30px; text-align: center; background: white; border-radius: 8px; margin-top: 20px;">
                    No customer accounts found.
                </p>
            <?php else: ?>
                <div class="product-table-wrapper">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td>#<?php echo htmlspecialchars($customer['id']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['email']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($customer['created_at'])); ?></td>
                                    <td class="action-buttons" style="display: flex; gap: 10px; flex-wrap: wrap;">
                                        <form method="POST" action="../actions/manage_user_action.php" style="display: inline;">
                                            <input type="hidden" name="user_id" value="<?php echo $customer['id']; ?>">
                                            <input type="hidden" name="action" value="promote_to_admin">
                                            <button type="submit" title="Promote to Admin" class="order-btn" style="padding: 5px 10px; font-size: 0.8rem; background-color: var(--secondary-color);">Promote</button>
                                        </form>

                                        <form method="POST" action="../actions/manage_user_action.php" style="display: inline;" onsubmit="return confirm('WARNING: Are you sure you want to delete this user? They will lose access.');">
                                            <input type="hidden" name="user_id" value="<?php echo $customer['id']; ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit" title="Delete User" class="remove-btn" style="color: #c0392b; font-size: 0.8rem;">DELETE</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

        <?php endif; // End tab=users 
        ?>
    </div>
</div>

<div id="orderDetailsModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="document.getElementById('orderDetailsModal').style.display='none'">&times;</span>
        <h3>Order Details: <span id="modalOrderId"></span></h3>
        <p><strong>Status:</strong> <span id="modalOrderStatus"></span></p>
        <p><strong>Date:</strong> <span id="modalOrderDate"></span></p>
        <hr>
        <h4>Items:</h4>
        <ul id="modalOrderItems" class="order-detail-list">
        </ul>
        <hr>
        <p class="summary-total">Total: <span id="modalOrderTotal"></span></p>
    </div>
</div>

</body>

</html>