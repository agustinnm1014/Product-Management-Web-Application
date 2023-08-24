<?php
// Include the database connection
include 'config.php';

// Fetch product data from database
$query = "SELECT * FROM products";
$result = $conn->query($query);

$products = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Close the database connection
$conn->close();

// Return JSON response
echo json_encode($products);
?>