<?php
// Include the database connection
include 'config.php';

$id = $_POST['id'];
$product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
$unit = mysqli_real_escape_string($conn, $_POST['unit']);
$price = mysqli_real_escape_string($conn, $_POST['price']);
$expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);
$inventory = mysqli_real_escape_string($conn, $_POST['inventory']);

// Update product data
$query = "UPDATE products SET product_name = '$product_name', unit = '$unit', price = '$price', expiry_date = '$expiry_date', inventory = '$inventory' WHERE id = '$id'";
$result = $conn->query($query);

if ($result) {
    echo json_encode(array('message' => 'Product updated successfully'));
} else {
    echo json_encode(array('message' => 'Error updating product'));
}

$conn->close();
?>