<?php
include '../includes/db.php';

// Access control: only admins can access this page
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.php?error=Access Denied: Admin required");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $image_url = '';

    // --- Image Upload Logic ---
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../assets/img/products/";
        // Generate a unique file name to prevent conflicts
        $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $file_name;
        
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check if image file is a actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check === false) {
            $uploadOk = 0;
            $error = "File is not an image.";
        }
        
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $uploadOk = 0;
            $error = "Sorry, only JPG, JPEG, and PNG files are allowed.";
        }
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            header("Location: ../pages/admin_dashboard.php?tab=menu&error=" . urlencode($error));
            exit();
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Store the relative path in the database
                $image_url = 'assets/img/products/' . $file_name;
            } else {
                header("Location: ../pages/admin_dashboard.php?tab=menu&error=Sorry, there was an error uploading your file.");
                exit();
            }
        }
    }
    // --- End Image Upload Logic ---

    // Insert Product into Database
    try {
        $sql = "INSERT INTO products (name, description, price, image_url) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $description, $price, $image_url]);

        header("Location: ../pages/admin_dashboard.php?tab=menu&success=Product added successfully!");
        exit();

    } catch (PDOException $e) {
        header("Location: ../pages/admin_dashboard.php?tab=menu&error=Database Error: Failed to add product.");
        exit();
    }
}
?>