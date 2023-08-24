<?php

include 'config.php';


$id = $_POST['id'];


$id = mysqli_real_escape_string($conn, $id);

// Delete data from the database using a prepared statement
$query = "DELETE FROM products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Product Deleted Successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>