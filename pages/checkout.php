<?php 
include '../includes/db.php'; 
include '../includes/header.php'; 

// Redirects (unchanged logic)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=Please log in to checkout.");
    exit();
}
if (empty($_SESSION['cart'])) {
    header("Location: menu.php?error=Your cart is empty.");
    exit();
}

// Totals
$cart = $_SESSION['cart'];
$subtotal = 0;
$delivery_fee = 50.00;
foreach ($cart as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$total_amount = $subtotal + $delivery_fee;
?>

<section class="cart-section">
    <div class="container">
        <h1 class="section-title" style="font-family: 'Feeling Passionate', cursive; font-size: 3rem;">Checkout</h1>
        
        <form action="../actions/place_order_action.php" method="POST" class="cart-container">
            <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">
            <input type="hidden" name="delivery_fee" value="<?php echo $delivery_fee; ?>">

            <div class="cart-items" style="height: fit-content;">
                <h2 style="font-size: 1.5rem; margin-bottom: 1.5rem;">Delivery Details</h2>
                
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" required placeholder="First name" class="form-control">
                </div>
                
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" required placeholder="Last name" class="form-control">
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" required placeholder="Address" class="form-control">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>" required placeholder="Email" class="form-control">
                </div>

                <div class="form-group">
                    <label>Order Notes</label>
                    <textarea name="notes" placeholder="Notes about your order" class="form-control" style="min-height: 120px;"></textarea>
                </div>
            </div>

            <div class="cart-items" style="height: fit-content;">
                <h2 style="font-size: 1.5rem; margin-bottom: 1.5rem;">Payment Details</h2>
                
                <div class="form-group">
                    <label style="margin-bottom: 1rem; display: block;">Payment Method</label>
                    
                    <label class="payment-option" style="display: flex; gap: 10px; align-items: center; margin-bottom: 10px; cursor: pointer;">
                        <input type="radio" name="payment_method" value="cod" checked onchange="togglePaymentFields()" style="width: auto;">
                        <span>Cash on delivery</span>
                    </label>

                    <label class="payment-option" style="display: flex; gap: 10px; align-items: center; margin-bottom: 10px; cursor: pointer;">
                        <input type="radio" name="payment_method" value="gcash" onchange="togglePaymentFields()" style="width: auto;">
                        <span>GCash</span>
                    </label>
                    <div id="gcash-field" style="display: none; margin-left: 25px; margin-bottom: 10px;">
                        <input type="text" name="gcash_number" placeholder="09123456789 (11 digits)" maxlength="11" pattern="09[0-9]{9}" title="Please enter a valid 11-digit GCash number starting with 09" class="form-control">
                    </div>

                    <label class="payment-option" style="display: flex; gap: 10px; align-items: center; margin-bottom: 10px; cursor: pointer;">
                        <input type="radio" name="payment_method" value="card" onchange="togglePaymentFields()" style="width: auto;">
                        <span>Card</span>
                    </label>
                    <div id="card-field" style="display: none; margin-left: 25px; margin-bottom: 10px;">
                        <input type="text" name="card_number" placeholder="1234 5678 1234 5678 (16 digits)" maxlength="16" pattern="[0-9]{16}" title="Please enter a valid 16-digit card number" class="form-control">
                    </div>
                </div>

                <div style="border-top: 2px solid var(--border-color); padding-top: 1.5rem; margin-top: 1.5rem;">
                    <h3 style="font-size: 1.2rem; margin-bottom: 1rem;">Your Order</h3>
                    
                    <div style="margin-bottom: 1rem;">
                        <?php foreach ($cart as $item): ?>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; color: var(--text-dark);">
                                <span><?php echo htmlspecialchars($item['name']); ?> (x<?php echo $item['quantity']; ?>)</span>
                                <span>₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; color: var(--text-dark);">
                        <span>Subtotal</span>
                        <span>₱<?php echo number_format($subtotal, 2); ?></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; color: var(--text-dark);">
                        <span>Delivery Charge</span>
                        <span>₱<?php echo number_format($delivery_fee, 2); ?></span>
                    </div>

                    <div style="border-top: 2px solid var(--border-color); padding-top: 1rem; display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: bold; color: var(--text-dark);">
                        <span>Total Amount (including VAT)</span>
                        <span>₱<?php echo number_format($total_amount, 2); ?></span>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <button type="submit" class="submit-btn" style="flex: 1; margin-top: 0;">CONFIRM</button>
                    <a href="cart.php" class="order-btn" style="flex: 1; margin-top: 0; background-color: var(--primary-color); color: var(--white); display: flex; align-items: center; justify-content: center;">BACK TO CART</a>
                </div>

            </div>
        </form>
    </div>
</section>

<script>
function togglePaymentFields() {
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    const gcashField = document.getElementById('gcash-field');
    const cardField = document.getElementById('card-field');
    const gcashInput = gcashField.querySelector('input');
    const cardInput = cardField.querySelector('input');

    // Reset fields
    gcashField.style.display = 'none';
    cardField.style.display = 'none';
    gcashInput.removeAttribute('required');
    cardInput.removeAttribute('required');

    if (paymentMethod === 'gcash') {
        gcashField.style.display = 'block';
        gcashInput.setAttribute('required', 'required');
    } else if (paymentMethod === 'card') {
        cardField.style.display = 'block';
        cardInput.setAttribute('required', 'required');
    }
}
</script>

<?php include '../includes/footer.php'; ?>