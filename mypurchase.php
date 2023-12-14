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

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch Mypurchase items from the database
$userId = $_SESSION['id'];
$sql = "SELECT mypurchase.*, products.quantity AS product_quantity FROM mypurchase INNER JOIN products ON mypurchase.product_id = products.id WHERE mypurchase.user_id = '$userId'";
$result = mysqli_query($conn, $sql);
$cartItems = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (mysqli_error($conn)) {
    echo "SQL Error: " . mysqli_error($conn);
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
      <meta name="viewport" content="initial-scale=1, maximum-scale=1.0">
      <!-- site metas -->
      <title>My Purchase | Ajok Furniture Shop Online</title>
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
   <!-- body -->
   <body style="background-color: #73A500; display: flex; flex-direction: column; min-height: 100vh;">

   <!-- header -->
   <?php include('navbar.php'); ?>
   <!-- end header -->
   <main style="flex: 1;">
      <div class="container mt-3">
         <div class="row">
            <table class="table">
               <thead class="table-dark">
                  <tr>
                     <th>Image</th>
                     <th>Product Name</th>
                     <th>Price</th>
                     <th>Status</th>
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
                              <td><?php echo $item['status']; ?></td>
                        </tr>
                     <?php endforeach; ?>
                  <?php else: ?>
                     <tr>
                        <td colspan="6">You don't have order right now.</td>
                     </tr>
                  <?php endif; ?>
               </tbody>
            </table>
         </div>
      </div>
   </main>
   </body>
      <!--  footer -->
      <footer>
        <?php include('footer.php'); ?>
      </footer>
      <!-- end footer -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
</html>