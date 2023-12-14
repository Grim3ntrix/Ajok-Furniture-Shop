<?php
session_start();
require_once 'connection.php';

// Check if the seller is authenticated
$isAuthenticated = isset($_SESSION['seller_id']);

// Redirect to the login page if the seller is not authenticated
if (!$isAuthenticated) {
    header('Location: login-seller.php');
    exit();
}

// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

// Update the status logic
if (isset($_POST['save_changes'])) {
    $status = $_POST['status'];
    $purchaseId = $_POST['purchase_id'];

    // Validate and sanitize input
    $status = mysqli_real_escape_string($conn, $status);
    $purchaseId = mysqli_real_escape_string($conn, $purchaseId);

    // Update the status
    $sql = "UPDATE mypurchase SET status = '$status' WHERE id = '$purchaseId'";
    mysqli_query($conn, $sql);

    header('Location: process-orders.php');
    exit();
}

// Fetch Mypurchase items with user and product details from the database
$sql = "SELECT mypurchase.*, mypurchase.id AS p_id, 
    users.fullname AS customer_name,
    users.mode_of_payment AS mode_of_payment,
    products.image AS product_image, 
    products.product_title AS product_title, 
    products.price
    FROM mypurchase
    INNER JOIN users ON mypurchase.user_id = users.id 
    INNER JOIN products ON mypurchase.product_id = products.id";
$result = mysqli_query($conn, $sql);
$myPurchaseItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
      <meta name="viewport" content="initial-scale=1, maximum-scale=1.0">
      <!-- site metas -->
      <title>Shop Order | Ajok Furniture Shop Online</title>
      <meta name="keywords" content="ApplianceMart Online Shopping">
      <meta name="description" content="This e-commerce website sell appliances online">
      <meta name="author" content="Richard Samberi">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-EXAMPLE_HASH" crossorigin="anonymous" >
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <!--[if lt IE 9]-->
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><!--[endif]-->
</head>

<body style="background-color: #73A500; display: flex; flex-direction: column; min-height: 100vh;">
    <header>
        <?php include('navbar-dashboard.php'); ?>
    </header>
    <main style="flex: 1;">
        <div class="container mt-4">
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead class="table-active">
                        <tr>
                            <th>Customer</th>
                            <th style="width: 150px;">Product Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Mode of Payment</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($myPurchaseItems)) : ?>
                            <tr>
                                <td colspan="7">
                                    <p class="text-center">No shop orders to display.</p>
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($myPurchaseItems as $purchase) : ?>
                                <tr>
                                    <td><?php echo $purchase['customer_name']; ?></td>
                                    <td style="width: 100px; height: 100px; align-items: center; justify-content: center; margin: 20px;">
                                        <?php $imagePath = 'product_images/' . $purchase['product_image'];
                                        if (file_exists($imagePath)) : ?>
                                            <img src="<?php echo $imagePath; ?>" alt="Product Image" class="img-fluid">
                                        <?php else : ?>Image Not Found
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $purchase['product_title']; ?></td>
                                    <td>₱<?php echo $purchase['price']; ?></td>
                                    <td class="w-10"><?php echo $purchase['mode_of_payment']; ?></td>
                                    <td class="w-10"><?php echo $purchase['status']; ?></td>
                                    <td class="product-actions">
                                        <button type="button" class="btn btn-primary mb-3 statusModalBtn" data-toggle="modal" data-target="#statusModal_<?php echo $purchase['p_id']; ?>"><i class="fas fa-info-circle"></i> Status</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer>
        <?php include('footer.php'); ?>
    </footer>
    <!-- Start Status Modals -->
    <?php foreach ($myPurchaseItems as $purchase): ?>
        <div class="modal fade" id="statusModal_<?php echo $purchase['p_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
            <form action="process-orders.php" method="post">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="statusModalLabel">Order Status</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Update Status:
                                <select class="p-1 form-control mt-3 col-6" style="border-radius: 4px;" name="status" id="">
                                    <option value="" selected>Open this select menu</option>
                                    <option value="Preparing-order">Preparing-order</option>
                                    <option value="Shipped-out">Shipped-out</option>
                                    <option value="Picked-up">Picked-up</option>
                                    <option value="Delivered">Delivered</option>
                                </select>
                            </p>
                            <input type="hidden" name="purchase_id" value="<?php echo $purchase['p_id']; ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" name="save_changes" class="btn btn-primary">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php endforeach; ?>
    <!-- End Status Modals -->
    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- JavaScript Modal-->
    <script>
        $(document).ready(function () {
            // Function to show the "Status" modal
            $('.statusModalBtn').on('click', function () {
                var modalId = $(this).data('target');
                $(modalId).modal('show');
            });
        });
    </script>
</body>

</html>