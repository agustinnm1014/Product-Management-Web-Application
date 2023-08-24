<?php
// Include the database connection
include 'config.php';


$product_id = $_GET['id'];


$query = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();


    $image_path = $product['image_path'];


    $product['image_path'] = $image_path;

    echo json_encode($product);
} else {
    echo "Product not Found";
}

$stmt->close();
$conn->close();
?>