<?php
session_start();

require_once 'connection.php';

$isAuthenticatedSeller = isset($_SESSION['SellerID']);
$isAuthenticatedUser = isset($_SESSION['id']);

if (isset($_GET['logout'])) {
  session_destroy();
  header('Location: index.php');
  exit();
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
      <title>Home | Ajok Furniture Shop Online </title>
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
      <style>
         body.fadeout {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
         }

         .rounded{
            background-color: #000;
         }

         .rounded:hover {
         background-color: #28a745;
         color: #fff;
            
         }
      </style>
      <!-- Include jQuery -->
      <script src="js/jquery.min.js"></script>
      <!-- Include your custom script -->
       <script>
        $(document).ready(function () {
            // Add smooth scrolling to the "Read More" button
            $("#a").on('click', function (event) {
                var hash = "#scroll-here"; // Change "target-section" to the actual id of the target section
                if (hash !== "") {
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 800, function () {
                        window.location.hash = hash;
                    });
                }
            });
        });
    </script>
   </head>
      <!-- header -->
   <header>
      <nav class="navbar navbar-expand-lg navbar-light" style="background-color:#3e363f;">
         <div class="container-fluid">
         <a class="navbar-brand" href="#"><img src="images/fevicon.png" width="80" height="100" alt="#" /></a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                  aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
               <li class="nav-item">

               </li>
               <li class="nav-item">
               <button class="rounded">
               <a class="btn text-white smooth-link" href="index.php">Home</a>
               </button>
               </li>
               <li class="nav-item">
               <button class="rounded">
               <a class="btn text-white " href="products.php">Products</a>
               </button>
               </li>
               <li class="nav-item">
               <button class="rounded">
               <a class="btn text-white smooth-link" href="aboutus.php">About Us</a>
               </button>
               </li>
               <li class="nav-item">
               <button class="rounded">
               <a class="btn text-white smooth-link" href="mypurchase.php">My Purchase</a>
               </button>
               </li>
               
               <li class="nav-item dropdown">
               
               <a class="btn text-white dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Account
               </a>
               <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" id="userDropdown">
                  <?php if ($isAuthenticatedUser || $isAuthenticatedSeller): ?>
                     <!-- Edit Profile link -->
                     <a class="dropdown-item" href="edit-profile.php">Profile</a>
                     <a class="dropdown-item smooth-link" id="logoutLink" href="?logout=1">Logout</a>
                  <?php else: ?>
                     <a class="dropdown-item smooth-link" id="loginLink" href="login.php">Login</a>
                     <a class="dropdown-item smooth-link" id="signupLink" href="signup.php">Signup</a>
                  <?php endif; ?>
               </div>
               </li>
            </ul>
         </div>
         </div>
      </nav>
   </header>
   <!-- end header -->
   <!-- body -->
   <body style="display: flex; flex-direction: column; min-height: 100vh; overflow-x: hidden;">


   <br><br>
   <main style="flex: 1;">
      <div class="row">
         <div class="col-12">
            <h3 class="mt-5 text-center text-warning">WELCOME TO AJOK FURNITURE SHOP</h3>
         </div>
      </div>
      <div class="row mt-5">
         <div class="col-6 text-right">
         <a href="products.php"><button class="btn btn-primary p-3">Shop Now</button></a>
         </div>
         <div class="col-6">
         <button class="btn btn-primary p-3" id="a">Read More</button>
         </div>
      </div>
   </main>
   <br><br><br> 
   <br><br><br><br> 
   <br><br>
   <div class="row mt-5">
      <div class="col-12 text-right">
         <figure><img src="images/6.jpg" class="object-fit-cover border rounded" alt="..."></figure>
      </div>
   </div>
   <div class="row">
      <div class="col-12" id="scroll-here">
         <h3 class="mt-5 text-center text-warning">The No. 1 Top Leading Furniture Shop</h3>
         <h3 class="mt-5 text-center text-warning">In Sogod Southern Leyte</h3>
      </div>
   </div><br><br>
      <!--  footer -->
      <footer>
         <?php include('footer.php'); ?>
      </footer>
      <!-- end footer -->
      <!-- Include Bootstrap JS -->
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>

   </body>
</html>