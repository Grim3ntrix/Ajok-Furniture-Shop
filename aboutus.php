<?php
session_start();
include('connection.php');

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
      <div class="container mt-4">
         <!-- CEO Section -->
         <div class="row">
            <div class="col-12 bg-white p-4 rounded">
               <h3 class="text-center mb-3">CEO</h3>
               <div class="d-flex justify-content-center">
                  <figure class="bg-white rounded-circle p-3" style="width: 150px; height: 150px;">
                     <img src="images/vanz.jpg" alt="" class="img-fluid" style="border-radius: 80%;">
                  </figure>
               </div>
            </div>
         </div>
      </div>
      <div class="container mt-4 bg-white">
         <div class="row">
            <div class="col-12 bg-white text-center p-4 rounded mb-4">
               <h3 class="mb-3">Business Partners</h3>
            </div>
         </div>
         <div class="row">
            <div class="col-md-3 col-sm-6 bg-white p-4 rounded mb-4">
               <h3 class="text-center mb-3">SphereX</h3>
               <div class="d-flex justify-content-center">
                  <figure class="bg-dark rounded-circle p-3" style="width: 100px; height: 100px;">
                     <img src="images/fevicon.png" alt="" class="img-fluid">
                  </figure>
               </div>
            </div>
            <div class="col-md-3 col-sm-6 bg-white p-4 rounded mb-4">
               <h3 class="text-center mb-3">Happy ESports</h3>
               <div class="d-flex justify-content-center">
                  <figure class="bg-dark rounded-circle p-3" style="width: 100px; height: 100px;">
                     <img src="images/fevicon.png" alt="" class="img-fluid">
                  </figure>
               </div>
            </div>
            <div class="col-md-3 col-sm-6 bg-white p-4 rounded mb-4">
               <h3 class="text-center mb-3">ApplianceMart</h3>
               <div class="d-flex justify-content-center">
                  <figure class="bg-dark rounded-circle p-3" style="width: 100px; height: 100px;">
                     <img src="images/fevicon.png" alt="" class="img-fluid">
                  </figure>
               </div>
            </div>
            <div class="col-md-3 col-sm-6 bg-white p-4 rounded mb-4">
               <h3 class="text-center mb-3">Larahub</h3>
               <div class="d-flex justify-content-center">
                  <figure class="bg-dark rounded-circle p-3" style="width: 100px; height: 100px;">
                     <img src="images/fevicon.png" alt="" class="img-fluid">
                  </figure>
               </div>
            </div>
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