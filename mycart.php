<?php
session_start();
include('connection.php');

// Check if the user is authenticated as a seller or a user
$isAuthenticatedUser = isset($_SESSION['id']);

// Redirect to the login page if the user is not authenticated
if (!$isAuthenticatedUser) {
    header('Location: login.php');
    exit();
}

// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

// Fetch cart items from the database
$userId = $_SESSION['id'];
$sql = "SELECT mycart.*, products.quantity AS product_quantity FROM mycart INNER JOIN products ON mycart.product_id = products.id WHERE mycart.user_id = '$userId'";
$result = mysqli_query($conn, $sql);
$cartItems = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (mysqli_error($conn)) {
    echo "SQL Error: " . mysqli_error($conn);
}


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selected_products'])) {
        $selectedProducts = $_POST['selected_products'];
        $submitButtonClicked = isset($_POST['submit_order']);

        // Fetch the current date
        $currentDate = date("Ymd");

        // Retrieve the last batch number from the database or initialize it to 0
        $lastBatchSql = "SELECT MAX(batch) AS last_batch FROM orders";
        $lastBatchResult = mysqli_query($conn, $lastBatchSql);
        $lastBatchRow = mysqli_fetch_assoc($lastBatchResult);
        $lastBatch = $lastBatchRow['last_batch'];

        // Extract the date and sequential number from the last batch
        $lastDate = substr($lastBatch, 0, 8);
        $lastSequentialNumber = intval(substr($lastBatch, -3));

        // If the current date is different from the last date, reset the sequential number to 1
        if ($currentDate !== $lastDate) {
            $sequentialNumber = 1;
        } else {
            // Increment the sequential number
            $sequentialNumber = $lastSequentialNumber + 1;
        }

        // If sequential number exceeds 999, reset it to 1
        if ($sequentialNumber > 999) {
            $sequentialNumber = 1;
        }

        // Pad the sequential number with leading zeros if necessary
        $paddedSequentialNumber = str_pad($sequentialNumber, 3, '0', STR_PAD_LEFT);

        // Generate the batch identifier with a dash
        $batch = $currentDate . '-' . $paddedSequentialNumber;

        // Insert selected products into the orders table only if the submit or placed order button is clicked
        if ($submitButtonClicked) {
            foreach ($selectedProducts as $productId) {
                // Get the corresponding cart item
                $cartItemSql = "SELECT * FROM mycart WHERE user_id = '$userId' AND product_id = '$productId'";
                $cartItemResult = mysqli_query($conn, $cartItemSql);
                $cartItem = mysqli_fetch_assoc($cartItemResult);

                // Get the updated quantity from the form
                $updatedQuantity = $_POST['quantity'][$productId];

                // Update the quantity in the mycart table
                $updateQuantitySql = "UPDATE mycart SET quantity = '$updatedQuantity' WHERE id = '{$cartItem['id']}'";
                mysqli_query($conn, $updateQuantitySql);

                // Insert the selected product into the orders table
                $orderSql = "INSERT INTO orders (mycart_id, batch) VALUES ('{$cartItem['id']}', '$batch')";
                mysqli_query($conn, $orderSql);
            }

            // Redirect to a success page or perform any additional actions
            header('Location: checkout.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- basic -->
    <link rel="icon" type="image/png" href="images/icon.png">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="This e-commerce website sells appliances online">
    <meta name="author" content="Richard Samberi">
    <!-- site metas -->
    <title>My Cart | Ajok Furniture Shop Online</title>
    <meta name="keywords" content="ApplianceMart Online Shopping">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/07672f603e.js" crossorigin="anonymous"></script>
</head>
<body style="background-color: #73A500; display: flex; flex-direction: column; min-height: 100vh;">
<!-- header -->
<header class="sticky-top ">
    <?php include('navbar.php'); ?>
</header>
<!-- end header inner -->
<!-- end header -->
<main style="flex: 1;">
    <div class="container mt-3">
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-2">
                        <?php
                            // Fetch drafts associated with the logged-in user
                            $draftOrders = array();

                            // Query to fetch draft orders for the specific user along with seller and product details
                            $userId = $_SESSION['id'];
                            $draftOrdersSql = "SELECT o.*, p.*, s.seller_shop_name
                            FROM orders o
                            INNER JOIN mycart mc ON o.mycart_id = mc.id
                            INNER JOIN products p ON mc.product_id = p.id
                            INNER JOIN sellers s ON p.seller_id = s.id
                            WHERE o.status = 'draft' AND mc.user_id = '$userId'";
                            $draftOrdersResult = mysqli_query($conn, $draftOrdersSql);

                            // Get the count of draft orders
                            $draftCount = mysqli_num_rows($draftOrdersResult);

                            // Check if the query returned any rows
                            if ($draftCount > 0) {
                                while ($row = mysqli_fetch_assoc($draftOrdersResult)) {
                                    $draftOrders[] = $row;
                                }
                            }
                        ?>
                        <button type="button" class="btn btn-secondary" name="view_drafts" data-toggle="modal" data-target="#draftModal">
                            <i class="fa-solid fa-file-pen"></i>&nbsp;Drafts (<?php echo $draftCount; ?>)
                        </button>
                    </div>
                </div>
            </div>
            <div class="table">
            <form method="POST" action="mycart.php">
            <table class="table">
                <thead class="table-active">
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody style="background-color:#ffffff;">
                    <?php if (!empty($cartItems)): ?>
                        <?php foreach ($cartItems as $item): ?>
                            <?php
                            // Fetch product details from the database based on the product_id
                            $productId = $item['product_id'];
                            $productSql = "SELECT * FROM products WHERE id = '$productId'";
                            $productResult = mysqli_query($conn, $productSql);
                            $product = mysqli_fetch_assoc($productResult);
                            ?>

                            <tr>
                                <td style="width: 100px; height: 100px; align-items: center; justify-content: center; margin: 20px;">
                                    <?php
                                    $imagePath = 'product_images/' . $product['image'];
                                    if (file_exists($imagePath)): ?>
                                        <img src="<?php echo $imagePath; ?>" alt="Product Image" class="img-fluid">
                                    <?php else: ?>
                                        Image Not Found
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $product['product_title']; ?></td>
                                <td><?php echo $product['price']; ?></td>
                                <td style="text-align: center;">
                                    <div class="input-group quantity-container" style="width: 123px; margin: 0 auto;">
                                        <button type="button" class="btn btn-secondary quantity-button" onclick="updateQuantity(<?php echo $productId; ?>, -1)">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <input type="text" class="form-control quantity-input" id="quantity-<?php echo $productId; ?>" style="font-size:16px;" value="<?php echo $item['quantity']; ?>" readonly data-max-quantity="<?php echo $product['quantity']; ?>">
                                        <button type="button" class="btn btn-secondary quantity-button" onclick="updateQuantity(<?php echo $productId; ?>, 1)">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                                <td>
                                    <input type="checkbox" class="product-checkbox" name="selected_products[]" value="<?php echo $item['product_id']; ?>" data-price="<?php echo $product['price']; ?>" data-quantity="<?php echo $item['quantity']; ?>">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Your cart is empty.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div id="subtotal-container" >
                <h4 class="subtotal-text">Subtotal:</h4>
                <h5 class="subtotal-amount">₱0.00</h5>
            </div>
            <div class="row" >
                <div class="col-md-12">
                    <div>
                        <!-- Add a hidden input field to pass the seller ID to the form -->
                        <input type="hidden" name="seller_id" value="seller_id_value">
                        <button type="submit" class="btn btn-info" name="submit_order" onclick="return checkForDrafts();">Checkout</button>
                    </div>
                </div>
            </div><br>
            </form>
            </div>
        </div>
    </div>

    <!-- Draft Modal -->
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal fade" id="draftModal" tabindex="-1" role="dialog" aria-labelledby="draftModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="draftModalLabel">Draft Orders</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php if (!empty($draftOrders)): ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Seller</th>
                                        <th>Product</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($draftOrders as $order): ?>
                                        <tr>
                                            <td><?= $order['seller_shop_name']; ?></td>
                                            <td><?= $order['product_title']; ?></td>
                                            <td><?= $order['created_at']; ?></td>
                                            <td>
                                                <!-- Add action buttons for each draft order (e.g., Edit, Delete, Checkout) -->
                                                <button type="button" class="btn btn-danger mb-1"><i class="fa fa-trash"></i></button><br>
                                                <!-- Add other action buttons as needed -->
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>You don't have draft orders right now.</p>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <?php if (!empty($draftOrders)): ?>
                            <a type="button" href="checkout.php" class="btn btn-success smooth-link"><i class="fas fa-arrow-right"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Draft Modal End-->
    <!-- Draft Modal Cannot proceed -->
    <div class="modal fade" id="draftMessageModal" tabindex="-1" role="dialog" aria-labelledby="draftMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="draftMessageModalLabel">Ops!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Empty your draft or complete checkout to proceed.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Draft Modal End-->
    <!-- No Item Selected Modal -->
    <div class="modal fade" id="noItemSelectedModal" tabindex="-1" role="dialog" aria-labelledby="noItemSelectedModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="noItemSelectedModalLabel">Ops!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    No item selected. Please select at least one item to proceed with checkout.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Cannot Proceed If there is a Draft and No Item Selected in Cart -->
    </main>
<footer>
    <?php include('footer.php'); ?>
</footer>

<script>
    function checkForDrafts() {
        // Check if any checkboxes are selected
        var selectedProducts = document.querySelectorAll(".product-checkbox:checked");
        var draftCount = <?php echo $draftCount; ?>;
        
        if (selectedProducts.length === 0) {
            // Show the "No Item Selected" modal
            $("#noItemSelectedModal").modal("show");
            return false; // Prevent the form submission
        } else if (draftCount > 0) {
            // Show the "Draft Message Modal" if there are drafts
            $("#draftMessageModal").modal("show");
            return false; // Prevent the form submission
        }

        // If checkboxes are selected and no drafts, allow the form submission
        return true;
    }
</script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/cart.js"></script>
</body>
</html>
