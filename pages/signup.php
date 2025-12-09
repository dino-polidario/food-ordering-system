<?php 
include '../includes/db.php'; 
include '../includes/header.php'; 
?>

<link rel="stylesheet" href="../assets/css/menu.css">
<div class="auth-container">
    <h2 style="text-align: center; margin-bottom: 1.5rem;">Create Account</h2>
    
    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <form action="../actions/register_action.php" method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" class="form-control" placeholder="Firstname Lastname" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="example@gmail.com" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="********" required>
        </div>
        <button type="submit" class="order-btn btn-block">Sign Up</button>
    </form>
    
    <div style="text-align: center; margin-top: 1rem;">
        Already have an account? <a href="login.php" style="color: var(--primary-color);">Sign In</a>
    </div>
</div>

<?php 
// No footer needed for auth pages usually, but we can add it if you want
// include '../includes/footer.php'; 
?>
</body>
</html>