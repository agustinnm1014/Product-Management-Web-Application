<?php
// Include the database connection
include 'config.php';

// Get data from the Ajax request
$product_name = $_POST['product_name'];
$unit = $_POST['unit'];
$price = $_POST['price'];
$expiry_date = $_POST['expiry_date'];
$inventory = $_POST['inventory'];


// Insert data into the database
$query = "INSERT INTO products (product_name, unit, price, expiry_date, inventory) VALUES ('$product_name', '$unit', '$price', '$expiry_date', '$inventory')";

if ($conn->query($query) === TRUE) {
    echo "Product created successfully";
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}

$conn->close();
?>