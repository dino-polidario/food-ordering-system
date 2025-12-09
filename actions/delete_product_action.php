<?php
include '../includes/db.php';

// Access control: only admins can access this page
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php?error=Access Denied: Admin required");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];

    try {
        // 1. Fetch the image URL to delete the file from the server later
        $stmt = $pdo->prepare("SELECT image_url FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // 2. Delete the record from the database
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            
            // 3. Delete the image file from the server
            $image_path = '../' . $product['image_url'];
            if (file_exists($image_path) && !empty($product['image_url'])) {
                unlink($image_path);
            }

            header("Location: ../pages/admin_dashboard.php?tab=menu&success=Product deleted successfully!");
            exit();
        } else {
            header("Location: ../pages/admin_dashboard.php?tab=menu&error=Product not found.");
            exit();
        }

    } catch (PDOException $e) {
        header("Location: ../pages/admin_dashboard.php?tab=menu&error=Database Error: Failed to delete product.");
        exit();
    }
} else {
    header("Location: ../pages/admin_dashboard.php?tab=menu&error=Invalid product ID.");
    exit();
}
?>