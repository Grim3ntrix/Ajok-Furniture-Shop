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

$showModal = false; // Flag to indicate whether to show the modal

if (isset($_POST['buy_now'])) {
    $userId = $_SESSION['id']; // Assuming user ID is stored in the session
    $productID = $_POST['product_id'];
    $status = 'Placed'; // Change this to your desired status
    $current_time = date('Y-m-d H:i:s');

    // Fetch product from the database based on the ID
    $sql = "SELECT * FROM products WHERE id = $productID";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);

    // Check if the quantity is greater than 0
    if ($product['quantity'] > 0) {
        // Decrement the quantity in the products table
        $updateSql = "UPDATE products SET quantity = quantity - 1 WHERE id = $productID";
        mysqli_query($conn, $updateSql);

        // Insert into mypurchase table
        $stmt = $conn->prepare("INSERT INTO mypurchase (user_id, product_id, status, created_at) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $userId, $productID, $status, $current_time);
        $stmt->execute();
        $stmt->close();

        // Redirect to the mypurchase.php page after purchase
        header('Location: mypurchase.php');
        exit();
    } else {
        $showModal = true; // Set the flag to show the modal
    }

    
}

// Check if product ID is provided
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch product from the database based on the ID
    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);
} else {
    // Redirect back to the products page if no ID is provided
    header("Location: index.php");
    exit();
}

// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

mysqli_query($conn, $sql);
if (mysqli_error($conn)) {
    echo "SQL Error: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="images/icon.png">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Information | Ajok Furniture Shop Online</title>
    <meta name="keywords" content="ApplianceMart Online Shopping">
    <meta name="description" content="This e-commerce website sells appliances online">
    <meta name="author" content="Richard Samberi">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <script src="https://kit.fontawesome.com/07672f603e.js" crossorigin="anonymous"></script>
    <style>

        .product-price {
            color: #000;
        }

        .product-reviews p{
            color: #000;
        }

        .product-availability {
            color: #000;
        }

        .product-description {
            color: #000;
        }
         
        .product-title {
            font-size: 24px;
            font-weight: bold;
        }

        .product-description h4 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .product-description p {
            font-size: 15px;
            font-weight: normal;
            margin-bottom: 10px;
        }

        .product-reviews {
            color: #000;
        }

        .product-reviews h4 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body style="background-color: #73A500; display: flex; flex-direction: column; min-height: 100vh;">
  <!-- header -->
     <?php include('navbar.php'); ?>
  <!-- end header -->
  <main style="flex: 1;">
    <div class="container mt-3">
      <form action="product-info.php" method="POST" enctype="multipart/form-data">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-sm-12 rounded" style="background-color:#ffffff; padding:15px;"><br>
                <div class="banner mb-2">
                    <h3 class="text-success"><?php echo $product['product_title']; ?></h3>
                </div>
                <div class="row">
                    <div class="col-12 form-group text-left">
                      <div class="product-image">
                        <?php $imagePath = 'product_images/' . $product['image']; ?>
                        <?php if (!empty($product['image']) && file_exists($imagePath)) : ?>
                            <img src="<?php echo $imagePath; ?>" alt="Product Image">
                        <?php else : ?>
                            <img src="images/placeholder-image.jpg" alt="Product Image Placeholder">
                        <?php endif; ?>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                      <p class="product-price">Price: ₱<?php echo $product['price']; ?></p>
                      <p class="product-availability">Available: <?php echo $product['quantity']; ?></p>
                    </div>
                    <div class="col-6">
                      <div class="action-buttons">
                        <!--<form action="add_to_cart.php" method="post">
                            <input type="hidden" name="product_id" value="?php echo $productId; ?>">
                            <input type="submit" name="add_to_cart" value="Add to Cart" class="btn btn-primary" style="width:50%;">
                        </form>-->
                        <!--<form action="checkout.php" method="post" class="mt-1">-->
                            <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                            <input type="submit" name="buy_now" id="zeroQuantityModal" value="Buy Now" class="btn btn-danger mt-3" style="width:50%;">
                        <!--</form>-->
                      </div>
                    </div>
                </div>
            </div>
        </div>
      </form>
    </div>
    <div class="container mt-3">
      <form action="seller-dashboard.php" method="POST" enctype="multipart/form-data">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-sm-12 rounded" style="background-color:#ffffff; padding:15px;"><br>
              <div class="product-description">
                <h4 class="text-left">Description:</h4>
                <p><?php echo $product['description']; ?></p>
              </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6 col-sm-12 rounded" style="background-color:#ffffff; padding:15px;"><br>
              <div class="product-reviews">
                  <h4 class="text-left">Reviews:</h4>
                  <?php
                  // Fetch reviews for the product from the database
                  $reviewsSql = "SELECT * FROM reviews WHERE product_id = $productId";
                  $reviewsResult = mysqli_query($conn, $reviewsSql);

                  if (mysqli_num_rows($reviewsResult) > 0) {
                      while ($review = mysqli_fetch_assoc($reviewsResult)) {
                          echo '<p>' . $review['review_text'] . '</p>';
                      }
                  } else {
                      echo '<p>No reviews available.</p>';
                  }
                  ?>
              </div>
            </div>
        </div>
      </form>
    </div>
    <!-- Modal for zero quantity -->
    <div class="modal" tabindex="-1" role="dialog" id="zeroQuantityModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cannot Purchase</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    The product is out of stock. You cannot purchase it at the moment.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Conditionally show the modal using JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/plugin.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const showModal = <?php echo json_encode($showModal); ?>;

            if (showModal) {
                $('#zeroQuantityModal').modal('show');
            }
        });
    </script>
  </main>
  </body>
    <footer>
      <?php include('footer.php'); ?>
    </footer>
</html>