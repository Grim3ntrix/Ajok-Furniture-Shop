<?php
require_once 'connection.php';

$isAuthenticatedSeller = isset($_SESSION['SellerID']);
$isAuthenticatedUser = isset($_SESSION['id']);

if (isset($_GET['logout'])) {
  session_destroy();
  header('Location: index.php');
  exit();
}
?>

<html>
<head>
  <title>Navbar</title>
  <link href="css/style.css" rel="stylesheet">
  <link href="fontawesome-free-6.4.0-web/css/fontawesome.css" rel="stylesheet">
  <link href="fontawesome-free-6.4.0-web/css/brands.css" rel="stylesheet">
  <link href="fontawesome-free-6.4.0-web/css/solid.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="images/fevicon.png">
  <!-- Add Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Add Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  

  <!-- Add custom CSS for smooth transition -->
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
</head>
<body style="overflow-x: hidden;">
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/navitem-active.js"></script>
  <script>
    // Check if the user is authenticated and toggle login/logout links accordingly
    const isAuthenticated = <?php echo ($isAuthenticatedUser || $isAuthenticatedSeller) ? 'true' : 'false'; ?>;

    $(document).ready(function() {
      if (isAuthenticated) {
        $('#loginLink, #signupLink').hide();
        $('#logoutLink').show();
      } else {
        $('#loginLink, #signupLink').show();
        $('#logoutLink').hide();
      }


    });
  </script>
</body>
</html>
