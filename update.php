<?php
// Include the database connection
include 'config.php';

$id = $_POST['id'];

// Sanitize and escape data
$id = mysqli_real_escape_string($conn, $id);

// Retrieve product data
$query = "SELECT * FROM products WHERE id = '$id'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    echo json_encode($product);
} else {
    echo json_encode(null);
}

$conn->close();
?>