<?php
include '../includes/db.php'; 
include '../includes/header.php'; 

// Authorization Check: Must be a logged-in customer
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=You must be logged in to view your account.");
    exit();
}
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: admin_dashboard.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$orders = [];
$fetch_error = '';

// Fetch all orders for the current user
try {
    $stmt = $pdo->prepare("SELECT id, total_amount, status, created_at FROM orders WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $fetch_error = "Could not retrieve order history.";
}

// Function to get the correct status class
function get_status_class($status) {
    switch ($status) {
        case 'completed': return 'status-completed';
        case 'cancelled': return 'status-cancelled';
        default: return 'status-pending';
    }
}
?>

<link rel="stylesheet" href="../assets/css/dashboard.css">

<div class="dashboard-container">
    <div class="dashboard-header">
        <h2 style="color: var(--primary-color);">Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?></h2>
        <p>Review your recent orders and manage your account.</p>
    </div>

    <?php if(isset($_GET['success'])): ?>
        <div class="alert" style="background-color: var(--success); color: white; margin-bottom: 20px; text-align: center;">
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php endif; ?>

    <h3>Order History</h3>

    <?php if ($fetch_error): ?>
        <div class="alert alert-error"><?php echo $fetch_error; ?></div>
    <?php elseif (empty($orders)): ?>
        <p style="text-align: center; padding: 30px; background: white; border-radius: 8px; margin-top: 20px;">
            You have no orders yet. Head to the <a href="menu.php">Menu</a> to place your first order!
        </p>
    <?php else: ?>
        <div class="table-wrapper">
            <table class="order-history-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($orders as $order): ?>
                    <tr>
                        <td>#<?php echo htmlspecialchars($order['id']); ?></td>
                        <td><?php echo date('M d, Y H:i', strtotime($order['created_at'])); ?></td>
                        <td>₱<?php echo htmlspecialchars(number_format($order['total_amount'], 2)); ?></td>
                        <td>
                            <span class="status-badge <?php echo get_status_class($order['status']); ?>">
                                <?php echo htmlspecialchars(ucfirst($order['status'])); ?>
                            </span>
                        </td>
                        <td>
                            <button class="order-btn" style="padding: 5px 10px;" onclick="showOrderDetails(<?php echo $order['id']; ?>)">View Details</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
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

<script src="../assets/js/dashboard.js"></script>
</body>
</html>