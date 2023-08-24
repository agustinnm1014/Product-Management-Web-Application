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

        <button type="button" class="btn btn-primary mb-1 float-end" data-bs-toggle="modal"
            data-bs-target="#addProductModal">
            Add Product
        </button>

        <!-- Product List Table -->
        <div class="table-responsive">
            <table class="table">

                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Expiry Date</th>
                        <th>Inventory</th>
                        <th>Inventory Cost</th>


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
                                pattern="^[A-Za-z0-9 ]+$" required>
                            <div class="form-text">Product name must contain letters, numbers, or spaces.</div>
                        </div>
                        <div class="mb-3">
                            <label for="unit" class="form-label">Unit</label>
                            <input type="text" class="form-control form-control-sm" id="unit" pattern="^[A-Za-z0-9 ]+$"
                                required>
                            <div class="form-text">Unit must contain letters, numbers, or spaces.</div>
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
                        <button type="submit" class="btn btn-primary btn-sm float-end">Create</button>
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
                    <form id="editForm">
                        <input type="hidden" id="editProductId"> <!-- Hidden field to store the product ID -->

                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Product Name</label>
                            <input type="text" class="form-control form-control-sm" id="editProductName"
                                pattern="^[A-Za-z0-9 ]+$" required>
                            <div class="form-text">Product name must contain letters, numbers, or spaces.</div>
                        </div>
                        <div class="mb-3">
                            <label for="editUnit" class="form-label">Unit</label>
                            <input type="text" class="form-control form-control-sm" id="editUnit"
                                pattern="^[A-Za-z0-9 ]+$" required>
                            <div class="form-text">Unit must contain letters, numbers, or spaces.</div>
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
                inventory: $('#inventory').val()

            };

            $.ajax({
                type: 'POST',
                url: 'create.php',
                data: product,
                success: function (response) {
                    alert('Product created successfully!');
                    $('#createForm')[0].reset();
                    $('#addProductModal').modal('hide'); // Close the modal
                    loadProductList(); // Refresh the product list
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

                        productList.append('<tr><td>' + product.product_name + '</td> <td>' + product.unit + '</td> <td>' + product.price + '</td> <td>' + formattedExpiryDate + '</td> <td>' + product.inventory + '</td> <td>' + (product.inventory * product.price) + '</td> <td> <button class="btn btn-success " onclick="editProduct(' + product.id + ')">Update</a> <button class="btn btn-danger ms-2" onclick="deleteProduct(' + product.id + ', \'' + product.product_name + '\')">Delete</button></td></tr>');

                    });

                }
            });
        }



        // Load initial product list on page load
        $(document).ready(function () {
            loadProductList();
        });

        // Update Product Information
        function editProduct(id) {
            // Send an AJAX request to retrieve the product data
            $.ajax({
                url: 'update.php', // Create this PHP file to fetch product data
                type: 'POST',
                data: { id: id },
                success: function (response) {
                    var product = JSON.parse(response);
                    // Populate the modal fields with product data
                    $('#editProductId').val(product.id);
                    $('#editProductName').val(product.product_name);
                    $('#editUnit').val(product.unit);
                    $('#editPrice').val(product.price);
                    $('#editExpiryDate').val(product.expiry_date);
                    $('#editInventory').val(product.inventory);

                    // Show the modal
                    $('#editProductModal').modal('show');
                }
            });
        }


        // Update Product Information
        function editProduct(id) {
            $.ajax({
                url: 'fetch_product.php', // Create this PHP file to fetch product data
                type: 'POST',
                data: { id: id },
                success: function (response) {
                    var product = JSON.parse(response);
                    // Populate the modal fields with product data
                    $('#editProductId').val(product.id);
                    $('#editProductName').val(product.product_name);
                    $('#editUnit').val(product.unit);
                    $('#editPrice').val(product.price);
                    $('#editExpiryDate').val(product.expiry_date);
                    $('#editInventory').val(product.inventory);

                    // Show the modal
                    $('#editProductModal').modal('show');
                }
            });
        }

        // Update Product
        $('#editForm').submit(function (event) {
            event.preventDefault();

            var updatedProduct = {
                id: $('#editProductId').val(),
                product_name: $('#editProductName').val(),
                unit: $('#editUnit').val(),
                price: $('#editPrice').val(),
                expiry_date: $('#editExpiryDate').val(),
                inventory: $('#editInventory').val()
            };

            $.ajax({
                type: 'POST',
                url: 'update_product.php', // Create this PHP file to update the product
                data: updatedProduct,
                success: function (response) {
                    alert('Product updated successfully!');
                    $('#editProductModal').modal('hide');
                    loadProductList();
                }
            });
        });


        // Delete Product
        function deleteProduct(productId, productName) {
            var confirmDelete = confirm("Are you sure you want to delete the product: " + productName + "?");

            if (confirmDelete) {
                $.ajax({
                    type: 'POST',
                    url: 'delete.php',
                    data: { id: productId }, // Send the product ID to the server
                    success: function (response) {
                        alert(response); // Show the response message from the server
                        loadProductList(); // Refresh the product list
                    }
                });
            }
        }



    </script>

</body>

</html>