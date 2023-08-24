<?php

include 'config.php';

// Fetch product data from the database
$query = "SELECT * FROM products";
$result = $conn->query($query);

$products = array();

if ($result) {

    while ($row = $result->fetch_assoc()) {

        $row['product_name'] = htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8');
        $products[] = $row;
    }
} else {

    echo "Error fetching products: " . $conn->error;
}

$conn->close();


echo json_encode($products);
?>