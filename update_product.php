<?php
// Include the database connection
include 'config.php';

$id = $_POST['id'];
$product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
$unit = mysqli_real_escape_string($conn, $_POST['unit']);
$price = mysqli_real_escape_string($conn, $_POST['price']);
$expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);
$inventory = mysqli_real_escape_string($conn, $_POST['inventory']);
$inventory_cost = $price * $inventory; // Calculate inventory cost

// Handle the new image upload
$new_image_path = '';
if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
    $new_image = $_FILES['new_image'];
    $new_image_name = basename($new_image['name']);
    $new_image_path = 'uploads/' . $new_image_name;
    move_uploaded_file($new_image['tmp_name'], $new_image_path);
}

// Update product data including inventory_cost
$query = "UPDATE products SET product_name = '$product_name', unit = '$unit', price = '$price', expiry_date = '$expiry_date', inventory = '$inventory', inventory_cost = '$inventory_cost', image_path = '$new_image_path' WHERE id = '$id'";
$result = $conn->query($query);

if ($result) {
    echo json_encode(array('message' => 'Product Updated Successfully'));
} else {
    echo json_encode(array('message' => 'Error Updating Product'));
}

$conn->close();
?>