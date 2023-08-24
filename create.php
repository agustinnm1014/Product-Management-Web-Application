<?php

include 'config.php';


$product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
$unit = mysqli_real_escape_string($conn, $_POST['unit']);
$price = floatval($_POST['price']);
$expiry_date = $_POST['expiry_date'];
$inventory = intval($_POST['inventory']);


if ($price <= 0 || $inventory < 0) {
    echo "Invalid price or inventory values.";
    exit;
}

// Calculate inventory_cost
$inventory_cost = $price * $inventory;

// Handle image upload
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


$check = getimagesize($_FILES["image"]["tmp_name"]);
if ($check !== false) {
    $uploadOk = 1;
} else {
    echo "File is not an image.";
    $uploadOk = 0;
}


if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
    echo "Error uploading file.";
    exit;
}


if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
} elseif ($_FILES["image"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Insert data into the database
        $query = "INSERT INTO products (product_name, unit, price, expiry_date, inventory, inventory_cost, image_path) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssdssds", $product_name, $unit, $price, $expiry_date, $inventory, $inventory_cost, $target_file);

        if ($stmt->execute()) {
            echo "Product Added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();
?>