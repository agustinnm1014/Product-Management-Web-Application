<?php
// Include the database connection
include 'config.php';

// Get data from the Ajax request
$id = $_POST['id'];

// Sanitize and escape the ID
$id = mysqli_real_escape_string($conn, $id);

// Delete data from the database
$query = "DELETE FROM products WHERE id = '$id'";

if ($conn->query($query) === TRUE) {
    echo "Product deleted successfully";
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}

$conn->close();
?>