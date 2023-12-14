
<?php
session_start();
require_once 'connection.php';

// Check if the seller is authenticated
$isAuthenticated = isset($_SESSION['seller_id']);
 
// Redirect to the login page if the seller is not authenticated
if (!$isAuthenticated) {
    header('Location: login-dashboard.php');
    exit();
}

// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

// Delete product logic
if (isset($_GET['delete'])) {
    $productId = $_GET['delete'];

    // Delete the product from the database
    $deleteQuery = "DELETE FROM products WHERE id = '$productId'";
    mysqli_query($conn, $deleteQuery);
    // Redirect to the current page to reflect the updated product list
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch products from the database

$sellerId = $_SESSION['seller_id'];
$sql = "SELECT * FROM products WHERE seller_id = '$sellerId'";

$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
   <!-- basic -->
   <link rel="icon" type="image/png" href="images/icon.png">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1.0">
    <!-- site metas -->
    <title>My Product | Ajok Furniture Shop Online</title>
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
</header><br>
  <main style="flex: 1;">
    <div class="container">
        <div class="row">
          <table class="table table-dark">
            <thead>
              <tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($products)): ?>
                <tr>
                  <td colspan="5" class="empty-message">
                    No products listed yet.
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($products as $product): ?>
                  <tr>
                    <td style="width: 100px; height: 100px; align-items: center; justify-content: center; margin: 20px;">
                      <?php
                      $image = 'product_images/' . $product['image'];
                      if (file_exists($image)) {
                        echo '<img src="' . $image . '" alt="Product Image" class="img-fluid">';
                      } else {
                        echo 'Image Not Found: ' . $image;
                      }
                      ?>
                    </td>
                    <td><?php echo $product['product_title']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td><?php echo $product['quantity']; ?></td>
                    <td>
                      <a href="edit-product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">
                        <i class="fa-sharp fa-solid fa-pen-to-square"></i>
                      </a>
                      <a href="#" class="btn btn-danger" onclick="confirmDelete(<?php echo $product['id']; ?>)">
                        <i class="fa-sharp fa-solid fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>

  <!-- Confirm Delete Modal -->
  <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <p>Are you sure you want to delete this product?</p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <a id="deleteProductLink" href="#" class="btn btn-danger">Delete</a>
              </div>
          </div>
      </div>
  </div>

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <!-- Script to handle delete confirmation -->
  <script>
      function confirmDelete(productId) {
          var deleteProductLink = document.getElementById('deleteProductLink');
          deleteProductLink.href = '?delete=' + productId;
          $('#deleteConfirmationModal').modal('show');
      }
  </script>
  
  <?php
    require_once 'footer.php';
  ?>
</body>
</html>




