<?php
include '../includes/db.php';

// 1. Authorization Check
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php?error=You must be logged in to place an order.");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_SESSION['cart'])) {
    $user_id = $_SESSION['user_id'];
    $total_amount = filter_input(INPUT_POST, 'total_amount', FILTER_VALIDATE_FLOAT);
    
    // --- Database Transaction Start ---
    try {
        // Ensure no other operations interfere
        $pdo->beginTransaction();

        // 2. Insert into orders table
        $sql_order = "INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'pending')";
        $stmt_order = $pdo->prepare($sql_order);
        $stmt_order->execute([$user_id, $total_amount]);
        
        // Get the ID of the newly created order
        $order_id = $pdo->lastInsertId();

        // 3. Insert into order_items table for each item in the session cart
        $sql_item = "INSERT INTO order_items (order_id, product_id, quantity, price_at_time_of_order) VALUES (?, ?, ?, ?)";
        $stmt_item = $pdo->prepare($sql_item);

        foreach ($_SESSION['cart'] as $item) {
            $stmt_item->execute([
                $order_id, 
                $item['id'], 
                $item['quantity'], 
                $item['price'] // Use the price from the session (safe from last-minute database changes)
            ]);
        }

        // 4. Commit transaction and clear cart
        $pdo->commit();
        unset($_SESSION['cart']);

        header("Location: ../pages/customer_dashboard.php?success=Order #{$order_id} placed successfully! Thank you.");
        exit();

    } catch (PDOException $e) {
        // 5. Rollback on failure
        $pdo->rollBack();
        error_log("Order Placement Failed: " . $e->getMessage());
        header("Location: ../pages/cart.php?error=Failed to place order due to a system error. Please try again.");
        exit();
    }

} else {
    header("Location: ../pages/cart.php?error=Your cart is empty or invalid request.");
    exit();
}
?>