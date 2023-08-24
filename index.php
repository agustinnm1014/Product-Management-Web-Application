<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-3">

        <h2 class="text-center">Product List</h2>


        <!-- Product List Table -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="6"></th>
                        <th class="text-center">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addProductModal">
                                Add Product
                            </button>
                        </th>
                    </tr>
                    <tr>
                        <th>Product Name</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Expiry Date</th>
                        <th>Inventory</th>
                        <th>Inventory Cost</th>
                        <th>Image</th>
                        <th> Actions</th>

                    </tr>
                </thead>
                <tbody id="productList">

                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createForm">
                        <div class="mb-3">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control form-control-sm" id="productName"
                                pattern="^(?=.*[A-Za-z])[A-Za-z0-9 ]+$" required>

                        </div>
                        <div class="mb-3">
                            <label for="unit" class="form-label">Unit</label>
                            <input type="text" class="form-control form-control-sm" id="unit" pattern="^[A-Za-z0-9 ]+$"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control form-control-sm" id="price" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="expiryDate" class="form-label">Expiry Date</label>
                            <input type="date" class="form-control form-control-sm" id="expiry_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="inventory" class="form-label">Available Inventory</label>
                            <input type="number" class="form-control form-control-sm" id="inventory" step="1" required>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control form-control-sm" id="image" accept="image/*"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm float-end">Add</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Update Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" enctype="multipart/form-data">
                        <input type="hidden" id="editProductId">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Product Name</label>
                            <input type="text" class="form-control form-control-sm" id="editProductName"
                                pattern="^(?=.*[A-Za-z])[A-Za-z0-9 ]+$" required>

                        </div>
                        <div class="mb-3">
                            <label for="editUnit" class="form-label">Unit</label>
                            <input type="text" class="form-control form-control-sm" id="editUnit"
                                pattern="^[A-Za-z0-9 ]+$" required>

                        </div>
                        <div class="mb-3">
                            <label for="editPrice" class="form-label">Price</label>
                            <input type="number" class="form-control form-control-sm" id="editPrice" step="0.01"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editExpiryDate" class="form-label">Expiry Date</label>
                            <input type="date" class="form-control form-control-sm" id="editExpiryDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="editInventory" class="form-label">Available Inventory</label>
                            <input type="number" class="form-control form-control-sm" id="editInventory" step="1"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="editImage" class="form-label">Current Image</label>
                            <img src="" alt="Current Product Image" id="currentImage"
                                style="max-width: 100px; max-height: 100px;">
                        </div>

                        <div class="mb-3">
                            <label for="editNewImage" class="form-label">New Image</label>
                            <input type="file" class="form-control form-control-sm" id="editNewImage" accept="image/*">
                        </div>


                        <button type="submit" class="btn btn-primary btn-sm float-end">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- JavaScript for Ajax Requests -->

    <script>
        // Create Product
        $('#createForm').submit(function (event) {
            event.preventDefault();

            var product = {
                product_name: $('#productName').val(),
                unit: $('#unit').val(),
                price: $('#price').val(),
                expiry_date: $('#expiry_date').val(),
                inventory: $('#inventory').val(),
                inventory_cost: ($('#price').val() * $('#inventory').val()).toFixed(2), // Calculate inventory cost
                image: $('#image')[0].files[0]  // Get the uploaded image file
            };

            // Validate if an image is selected
            if (!product.image) {
                alert('Please select an image.');
                return;
            }

            var formData = new FormData();
            formData.append('image', product.image);
            delete product.image;
            for (var key in product) {
                formData.append(key, product[key]);
            }

            $.ajax({
                type: 'POST',
                url: 'create.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    alert('Product created successfully!');
                    $('#createForm')[0].reset();
                    $('#addProductModal').modal('hide');
                    loadProductList();
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    alert('Error creating product: ' + error);
                }
            });
        });

        // Display Product List
        function loadProductList() {
            $.ajax({
                type: 'GET',
                url: 'read.php',
                success: function (response) {
                    var products = JSON.parse(response);
                    var productList = $('#productList');
                    productList.empty();

                    products.forEach(function (product) {
                        var expiryDate = new Date(product.expiry_date);
                        var formattedExpiryDate = expiryDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

                        productList.append('<tr><td>' + product.product_name + '</td> <td>' + product.unit + '</td> <td>' + product.price + '</td> <td>' + formattedExpiryDate + '</td> <td>' + product.inventory + '</td> <td>' + (product.inventory * product.price).toFixed(2) + '</td> <td> <img src="' + product.image_path + '" alt="Product Image" style="max-width: 100px; max-height: 100px;"> </td> <td> <div class="d-flex flex-column flex-sm-row"> <button class="btn btn-success mb-1" onclick="editProduct(' + product.id + ')">Update</button> <button class="btn btn-danger ms-sm-2" onclick="deleteProduct(' + product.id + ', \'' + product.product_name + '\')">Delete</button> </div></td></tr>');



                    });

                }
            });
        }

        function editProduct(productId) {
            $.ajax({
                type: 'GET',
                url: 'get_product_details.php',
                data: { id: productId },
                success: function (response) {
                    var product = JSON.parse(response);
                    $('#editProductId').val(product.id);
                    $('#editProductName').val(product.product_name);
                    $('#editUnit').val(product.unit);
                    $('#editPrice').val(product.price);
                    $('#editExpiryDate').val(product.expiry_date);
                    $('#editInventory').val(product.inventory);


                    $('#currentImage').attr('src', product.image_path);

                    $('#editProductModal').modal('show');
                }
            });
        }

        // Handle the update form submission
        $('#editForm').submit(function (event) {
            event.preventDefault();

            var updatedProduct = {
                id: $('#editProductId').val(),
                product_name: $('#editProductName').val(),
                unit: $('#editUnit').val(),
                price: $('#editPrice').val(),
                expiry_date: $('#editExpiryDate').val(),
                inventory: $('#editInventory').val(),
                inventory_cost: ($('#editPrice').val() * $('#editInventory').val()).toFixed(2), // Calculate updated inventory cost
                new_image: $('#editNewImage')[0].files[0] // Get the new uploaded image file
            };

            var formData = new FormData();
            for (var key in updatedProduct) {
                formData.append(key, updatedProduct[key]);
            }

            $.ajax({
                type: 'POST',
                url: 'update_product.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    alert('Product updated successfully!');
                    $('#editForm')[0].reset();
                    $('#editProductModal').modal('hide');
                    loadProductList();
                }
            });
        });

        // Load initial product list on page load
        $(document).ready(function () {
            loadProductList();
        });


        // Delete Product
        function deleteProduct(productId, productName) {
            var confirmDelete = confirm("Are you sure you want to delete the product: " + productName + "?");

            if (confirmDelete) {
                $.ajax({
                    type: 'POST',
                    url: 'delete.php',
                    data: { id: productId },
                    success: function (response) {
                        alert(response);
                        loadProductList();
                    }
                });
            }
        }



    </script>

</body>

</html>
