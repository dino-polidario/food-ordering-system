<?php 
include '../includes/db.php'; 
include '../includes/header.php'; 

// Fetch all products
$products = [];
try {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id ASC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Graceful error handling for database issues
    $fetch_error = "We are currently unable to load the menu. Please check back soon.";
}
?>

<section class="menu-section">
    <h2>Discover Our Delicious Musubi Menu</h2>
    
    <?php if(isset($_GET['success'])): ?>
        <div class="alert" style="background-color: var(--success); color: white; max-width: 800px; margin: 0 auto 20px; text-align: center;">
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php endif; ?>

    <?php if(isset($fetch_error)): ?>
        <div class="alert alert-error" style="max-width: 800px; margin: 0 auto 20px; text-align: center;">
            <?php echo $fetch_error; ?>
        </div>
    <?php elseif (empty($products)): ?>
        <div class="alert" style="background-color: var(--warning); color: var(--header-bg); max-width: 800px; margin: 0 auto 20px; text-align: center;">
            The kitchen is setting up! No menu items are available yet. (Admin needs to add items).
        </div>
    <?php else: ?>

        <div class="menu-grid">
            <?php foreach($products as $product): ?>
            <div class="menu-card">
                <div class="menu-image">
                    <img src="../<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
                <div class="card-content">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>

                    <div class="card-footer">
                        <span class="product-price">₱<?php echo htmlspecialchars(number_format($product['price'], 2)); ?></span>
                        
                        <form action="../actions/add_to_cart_action.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                            <input type="number" name="quantity" value="1" min="1" max="99" style="width: 60px; padding: 5px; border: 1px solid #ccc; border-radius: 5px;">
                            <button type="submit" class="order-btn" style="margin-left: 10px;">
                                <i class="material-icons" style="font-size: 16px;">add_shopping_cart</i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</section>

</body>
</html>