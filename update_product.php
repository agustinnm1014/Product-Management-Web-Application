<?php
// Assuming you have a database connection established
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you're using proper validation and sanitization for the inputs
    $productId = $_POST['id'];
    $productName = $_POST['product_name'];
    $unit = $_POST['unit'];
    $price = $_POST['price'];
    $expiryDate = $_POST['expiry_date'];
    $inventory = $_POST['inventory'];

    // Update the product details in the database
    $query = "UPDATE products SET product_name = '$productName', unit = '$unit', price = '$price', expiry_date = '$expiryDate', inventory = '$inventory' WHERE id = $productId";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "Product updated successfully!";
    } else {
        echo "Failed to update product";
    }
} else {
    echo "Invalid request";
}

mysqli_close($connection);
?>