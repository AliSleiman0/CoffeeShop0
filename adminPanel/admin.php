<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Coffee Shop Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+z74J7X2nq5dhns3gYO9J+Whcd5uz2+nXvpCk4H" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- For icons -->
</head>

<body>
    <!-- Sidebar Navigation -->
    <div class="d-flex">
        <div class="bg-dark text-white p-3 position-fixed" style="width: 220px; min-height: 100vh;">
            <h4>Navigation</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#products"><i class="fas fa-coffee"></i> Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#customers"><i class="fas fa-users"></i> Registered Customers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#orders"><i class="fas fa-users"></i> Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#blogs"><i class="fas fa-blog"></i> Blogs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#testimonials"><i class="fas fa-quote-right"></i> Testimonials</a>
                </li>
            </ul>
        </div>
        <div style="margin-left: 220px;"> <!-- Adjust margin-left to accommodate the fixed navbar -->

            <!-- Main Content Area -->
            <div class="container p-4">

                <?php
                require('..\users\db.php');
                // Fetch products
                $productQuery = "SELECT * FROM menuitems";
                $productResult = $con->query($productQuery);

                // Fetch customers
                $customerQuery = "SELECT * FROM logins";
                $customerResult = $con->query($customerQuery);

                // Fetch blogs
                $blogQuery = "SELECT * FROM blogs";
                $blogResult = $con->query($blogQuery);

                // Fetch testimonials
                $testimonialQuery = "SELECT * FROM testimonials";
                $testimonialResult = $con->query($testimonialQuery);

                $orderQuery = "SELECT `orders`.order_id, `orders`.customer_id, `orders`.order_date, `orders`.total_amount, `orders`.address, logins.name as customer_name
               FROM `orders`
               JOIN `logins` ON `orders`.customer_id = logins.id"; // Assuming you have a customers table
                $orderResult = mysqli_query($con, $orderQuery);
                ?>
                <!-- Products Section -->
                <h2 id="products">Products</h2>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
                    <!-- Trigger Button -->
                    Add Item
                </button>


                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Loop through products and display them
                        if ($productResult->num_rows > 0) {
                            foreach ($productResult as $product) {
                                echo '<tr>
                                <td>' . htmlspecialchars($product["ItemID"]) . '</td>
                                <td>' . htmlspecialchars($product["Title"]) . '</td>
                                <td>' . htmlspecialchars($product["Image"]) . '</td>
                                <td>$' . htmlspecialchars($product["Price"]) . '</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#editProductModal" title="Edit" onclick="productEditForm(this)"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#deleteItemModal" title="Delete"  onclick="setProductID(this)"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>';
                            }
                        } else {
                            echo '<tr><td colspan="5">No products found</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>

                </head>

                <body>

                    <!-- Modal Item Confirm Deletion -->

                    <div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteItemModalLabel">Confirm Item Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this item?
                                </div>
                                <div class="modal-footer">
                                    <form id="deleteItemForm" action="delete_item.php" method="POST">
                                        <input type="hidden" id="productID" name="productID">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Add Items-->
                    <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
                        <div class="modal-dialog" style="max-width: 500px;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addItemModalLabel">Add Item</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form to add item -->
                                    <form action="add_item.php" method="POST">
                                        <div class="mb-3">
                                            <label for="itemName" class="form-label">Item Name</label>
                                            <input type="text" class="form-control" id="itemName" name="itemName" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="imageFileLink" class="form-label">Item Image File Link</label>
                                            <input type="text" class="form-control" id="imageFileLink" name="imageFileLink" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="itemPrice" class="form-label">Item Price</label>
                                            <textarea class="form-control" id="itemPrice" name="itemPrice" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Product Modal -->
                    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editProductForm" action="update_item.php" method="POST">
                                        <input type="hidden" id="editProductID" name="productID">
                                        <div class="mb-3">
                                            <label for="productName" class="form-label">Product Name</label>
                                            <input type="text" class="form-control" id="productName" name="productName" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="productImage" class="form-label">Product Image</label>
                                            <input type="text" class="form-control" id="productImage" name="productImage" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="productPrice" class="form-label">Product Price</label>
                                            <input type="number" class="form-control" id="productPrice" name="productPrice" step="0.01" required>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" form="editProductForm">Save
                                        Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Registered Customers Section -->
                    <h2 id="customers">Registered Customers</h2>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                        Add Customer
                    </button>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Customer ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop through customers and display them
                            if ($customerResult->num_rows > 0) {
                                foreach ($customerResult as $customer) {
                                    echo '<tr>
                                <td>' . htmlspecialchars($customer["id"]) . '</td>
                                <td>' . htmlspecialchars($customer["name"]) . '</td>
                                <td>' . htmlspecialchars($customer["email"]) . '</td>
                                <td>' . htmlspecialchars($customer["number"]) . '</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#editCustomerModal" title="Edit" onclick="customerEditForm(this)"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#deleteCustomerModal" title="Delete" onclick="setDeleteCustomerID(this)"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="5">No customers found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>


                    <!-- Modal Add Customer -->
                    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
                        <div class="modal-dialog" style="max-width: 500px;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addCustomerModalLabel">Add Customer</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form to add customer -->
                                    <form action="addCus.php" method="POST">
                                        <div class="mb-3">
                                            <label for="customerName" class="form-label">Customer Name</label>
                                            <input type="text" class="form-control" id="customerName" name="customerName" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="customerNumber" class="form-label">Customer Number</label>
                                            <input type="text" class="form-control" id="customerNumber" name="customerNumber" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="customerEmail" class="form-label">Customer Email</label>
                                            <input type="email" class="form-control" id="customerEmail" name="customerEmail" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="customerPassword" class="form-label">Customer Password</label>
                                            <input type="password" class="form-control" id="customerPassword" name="customerPassword" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Customer Modal -->
                    <div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editCustomerModalLabel">Edit Customer</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editCustomerForm" action="updateCus.php" method="POST">
                                        <input type="hidden" id="editCustomerID1" name="customerID">
                                        <div class="mb-3">
                                            <label for="customerName" class="form-label">Customer Name</label>
                                            <input type="text" class="form-control" id="customerName1" name="customerName" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="customerEmail" class="form-label">Customer Email</label>
                                            <input type="email" class="form-control" id="customerEmail1" name="customerEmail" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="customerPhoneNumber" class="form-label">Customer Phone
                                                Number</label>
                                            <input type="text" class="form-control" id="customerPhoneNumber1" name="customerPhoneNumber" required>
                                        </div>
                                    </form>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" form="editCustomerForm">Save
                                        Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Customer Modal -->
                    <div class="modal fade" id="deleteCustomerModal" tabindex="-1" aria-labelledby="deleteCustomerModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteCustomerModalLabel">Confirm Customer Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this customer?
                                </div>
                                <div class="modal-footer">
                                    <form id="deleteCustomerForm" action="deleteCus.php" method="POST">
                                        <input type="hidden" id="deleteCustomerID" name="customerID">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <h2 id="orders">Orders</h2>

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Order Date</th>
                                <th>Total Amount</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop through orders and display them
                            if ($orderResult->num_rows > 0) {
                                foreach ($orderResult as $order) {
                                    echo '<tr>
                                <td>' . htmlspecialchars($order["order_id"]) . '</td>
                                <td>' . htmlspecialchars($order["customer_name"]) . '</td>
                                <td>' . htmlspecialchars($order["order_date"]) . '</td>
                                <td>$' . htmlspecialchars($order["total_amount"]) . '</td>
                                <td>' . htmlspecialchars($order["address"]) . '</td>
                                <td>
                                 
                                    <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#deleteOrderModal" title="Delete" onclick="setOrderID(this)"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6">No orders found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>

                    <div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-labelledby="deleteOrderModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteOrderModalLabel">Confirm Order Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this order?
                                </div>
                                <div class="modal-footer">
                                    <form id="deleteOrderForm" action="deleteOrder.php" method="POST">
                                        <input type="hidden" id="deleteOrderID" name="orderID">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>




                    <!-- Blogs Section -->
                    <h2 id="blogs">Blogs</h2>

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Blog ID</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Link</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop through blogs and display them
                            if ($blogResult->num_rows > 0) {
                                foreach ($blogResult as $blog) {
                                    echo '<tr>
                            <td>' . htmlspecialchars($blog["id"]) . '</td>
                            <td>' . htmlspecialchars($blog["title"]) . '</td>
                            <td>' . htmlspecialchars($blog["author"]) . '</td>
                            <td>' . htmlspecialchars($blog["image"]) . '</td> ' .
                                        '<td>' . htmlspecialchars($blog["description"]) . '</td>' .
                                        '<td>' . htmlspecialchars($blog["link"]) . '</td>' .
                                        '<td>
                                <button class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit" data-bs-target="#editBlogModal" onclick="blogEditForm(this)"><i class="fas fa-edit"></i></button>
                               
                            </td>
                        </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="7">No blogs found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Edit Blog Modal -->
                    <div class="modal fade" id="editBlogModal" tabindex="-1" aria-labelledby="editBlogModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editBlogModalLabel">Edit Blog</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editBlogForm" action="updateBlogs.php" method="POST">
                                        <input type="hidden" id="editBlogID" name="blogID">
                                        <div class="mb-3">
                                            <label for="blogTitle" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="blogTitle" name="blogTitle" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="blogAuthor" class="form-label">Author</label>
                                            <input type="text" class="form-control" id="blogAuthor" name="blogAuthor" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="blogImage" class="form-label">Image URL</label>
                                            <input type="text" class="form-control" id="blogImage" name="blogImage" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="blogDescription" class="form-label">Description</label>
                                            <textarea class="form-control" id="blogDescription" name="blogDescription" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="blogLink" class="form-label">Link</label>
                                            <input type="text" class="form-control" id="blogLink" name="blogLink" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Testimonials Section -->
                    <h2 id="testimonials">Testimonials</h2>

                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Testimonial ID</th>
                                <th>content</th>
                                <th>Image</th>
                                <th>Author</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop through testimonials and display them
                            if ($testimonialResult->num_rows > 0) {
                                foreach ($testimonialResult as $testimonial) {
                                    echo '<tr>
                                <td>' . htmlspecialchars($testimonial["id"]) . '</td>' .
                                        '<td>' . htmlspecialchars($testimonial["content"]) . '</td>' .
                                        '<td>' . htmlspecialchars($testimonial["user_image"]) . '</td>' .
                                        '<td>' . htmlspecialchars($testimonial["user_name"]) . '</td>' .
                                        '<td>
                                    <button class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit"data-bs-toggle="modal" data-bs-target="#updateTestimonialModal" onclick="testimonialEditForm(this)"><i class="fas fa-edit"></i></button>
                                  
                                </td>
                            </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6">No testimonials found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>

            </div>
        </div>

        <!-- Update Testimonial Modal -->
        <div class="modal fade" id="updateTestimonialModal" tabindex="-1" aria-labelledby="updateTestimonialModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateTestimonialModalLabel">Update Testimonial</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateTestimonialForm" action="updateTest.php" method="POST">
                            <input type="hidden" id="testimonialID" name="testimonialID">
                            <div class="mb-3">
                                <label for="testimonialContent" class="form-label">Content</label>
                                <textarea class="form-control" id="testimonialContent" name="testimonialContent" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="testimonialImage" class="form-label">Image URL</label>
                                <input type="text" class="form-control" id="testimonialImage" name="testimonialImage" required>
                            </div>
                            <div class="mb-3">
                                <label for="testimonialAuthor" class="form-label">Author</label>
                                <input type="text" class="form-control" id="testimonialAuthor" name="testimonialAuthor" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Testimonial</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Include jQuery library -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            function setProductID(button) {
                var row = button.closest('tr');
                var productID = row.cells[0].textContent;
                document.getElementById('productID').value = productID;
            }
        </script>
        <script>
            function productEditForm(button) {
                var row = button.closest('tr');
                var productID = row.cells[0].textContent;
                var productName = row.cells[1].textContent;
                var productImage = row.cells[2].textContent;
                var productPrice = row.cells[3].textContent.replace('$', '');

                document.getElementById('editProductID').value = productID;
                document.getElementById('productName').value = productName;
                document.getElementById('productImage').value = productImage;
                document.getElementById('productPrice').value = productPrice;
            }
        </script>

        <script>
            function setCustomerID(button) {
                var row = button.closest('tr');
                var customerID = row.cells[0].textContent;
                document.getElementById('editCustomerID').value = customerID;
            }
        </script>

        <script>
            function customerEditForm(button) {
                var row = button.closest('tr');
                var customerID = row.cells[0].textContent;
                var customerName = row.cells[1].textContent;
                var customerEmail = row.cells[2].textContent;
                var customerPhoneNumber = row.cells[3].textContent;

                document.getElementById('editCustomerID1').value = customerID;
                document.getElementById('customerName1').value = customerName;
                document.getElementById('customerEmail1').value = customerEmail;
                document.getElementById('customerPhoneNumber1').value = customerPhoneNumber;


            }

            function testimonialEditForm(button) {
                var row = button.closest('tr');
                var testimonialID = row.cells[0].textContent;
                var testimonialContent = row.cells[1].textContent;
                var testimonialImage = row.cells[2].textContent;
                var testimonialAuthor = row.cells[3].textContent;

                document.getElementById('testimonialID').value = testimonialID;
                document.getElementById('testimonialContent').value = testimonialContent;
                document.getElementById('testimonialImage').value = testimonialImage;
                document.getElementById('testimonialAuthor').value = testimonialAuthor;

            }
        </script>
        <script>
            function blogEditForm(button) {
                var row = button.closest('tr');
                var blogID = row.cells[0].textContent;
                var blogTitle = row.cells[1].textContent;
                var blogAuthor = row.cells[2].textContent;
                var blogImage = row.cells[3].textContent;
                var blogDescription = row.cells[4].textContent;
                var blogLink = row.cells[5].textContent;

                document.getElementById('editBlogID').value = blogID;
                document.getElementById('blogTitle').value = blogTitle;
                document.getElementById('blogAuthor').value = blogAuthor;
                document.getElementById('blogImage').value = blogImage;
                document.getElementById('blogDescription').value = blogDescription;
                document.getElementById('blogLink').value = blogLink;

                // Show the edit blog modal
                $('#editBlogModal').modal('show');
            }
        </script>


        <script>
            function setDeleteCustomerID(button) {
                var row = button.closest('tr');
                var customerID = row.cells[0].textContent;
                document.getElementById('deleteCustomerID').value = customerID;
            }
        </script>


        <script>
            function setOrderID(button) {
                var row = button.closest('tr');
                var orderID = row.cells[0].textContent;
                document.getElementById('deleteOrderID').value = orderID;

            }
        </script>

        </script>

        <!-- Bootstrap JS and FontAwesome -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip(); // Initialize tooltips
            });


            $(document).ready(function() {
                // Smooth scroll to anchor links
                $('a[href^="#"]').on('click', function(event) {
                    var target = $(this.getAttribute('href'));
                    if (target.length) {
                        event.preventDefault();
                        $('html, body').stop().animate({
                            scrollTop: target.offset().top
                        }, 1000);
                    }
                });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    </div>
    </div>

</body>

</html>