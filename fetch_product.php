<?php
// Assuming you have a database connection established
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $productId = $_POST['id'];

    // Fetch the product data based on the provided ID
    $query = "SELECT * FROM products WHERE id = $productId";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $productData = mysqli_fetch_assoc($result);
        echo json_encode($productData);
    } else {
        echo json_encode(['error' => 'Failed to fetch product data']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

mysqli_close($connection);
?>