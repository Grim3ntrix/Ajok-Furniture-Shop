<?php
session_start();
include('connection.php');

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
      <title>Product | Ajok Furniture Shop Online </title>
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
      <div class="container mt-5">
         <?php if (empty($products)) : ?>
               <p>No products to display.</p>
         <?php else : ?>
            <div class="row products-list">
               <?php foreach ($products as $product): ?>
                  <div class="col-lg-3 col-md-4 col-sm-6" style="margin-bottom: 20px;">
                     <!-- Display product details -->
                     <a href="product-info.php?id=<?php echo $product['id']; ?>" class="card-link">
                        <div class="card" style="height: 100%;">
                           <?php $imagePath = 'product_images/' . $product['image']; ?>
                           <?php if (!empty($product['image']) && file_exists($imagePath)): ?>
                              <img src="<?php echo $imagePath; ?>" class="card-img-top product-image" alt="Product Image" style="width: 100%; height: 200px; object-fit: contain;">
                           <?php else: ?>
                              <img src="images/placeholder-image.jpg" class="card-img-top product-image" alt="Product Image Placeholder" style="width: 100%; height: 150px; object-fit: contain;">
                           <?php endif; ?>
                           <div class="card-body" style="height: 100%;">
                              <h5 class="card-titles" style="color:#000;"><?php echo $product['product_title']; ?></h5>
                              <p class="card-text" style="color:#000;">Price: ₱<?php echo $product['price']; ?></p>
                              <p class="card-text" style="color:#000;">Available: <?php echo $product['quantity']; ?></p>
                              <!-- Add more details as needed -->
                           </div>
                        </div>
                     </a>
                  </div>
               <?php endforeach; ?>
            </div>
         <?php endif; ?>
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