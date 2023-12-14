<?php
require_once 'connection.php';

$isAuthenticated = isset($_SESSION['seller_id']);

if (!$isAuthenticated) {
    header('Location: login-seller.php');
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

global $conn;

// Fetch the count of mypurchase entries
$sqlCount = "SELECT COUNT(id) as purchase_count FROM mypurchase WHERE status = 'Placed'";
$resultCount = mysqli_query($conn, $sqlCount);

// Check if the query was successful
if (!$resultCount) {
    die("Error fetching purchase count: " . mysqli_error($conn));
}

$productCounts = mysqli_fetch_assoc($resultCount);
$purchaseCount = $productCounts['purchase_count'];

// Free up the resources associated with the result set
mysqli_free_result($resultCount);

// Close the connection (you might want to remove this line if you're using the connection elsewhere)

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
    <title>Navbar Seller</title>
    <meta name="keywords" content="ApplianceMart Online Shopping">
    <meta name="description" content="This e-commerce website sells appliances online">
    <meta name="author" content="Richard Samberi">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs -->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <!--[if lt IE 9]-->

    <!--[endif]-->
    <script src="https://kit.fontawesome.com/07672f603e.js" crossorigin="anonymous"></script>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
    <nav class="navbar navbar-expand-lg" style="background-color:#3e363f;">
        <a class="navbar-brand" href="#"><img src="images/fevicon.png" width="80" height="100" alt="#" /></a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item pr-2">
                    <button class="rounded">
                    <a class="btn text-white smooth-link" href="seller-dashboard.php">New</a>
                    </button>
                </li>
                <li class="nav-item pr-2">
                    <button class="rounded">
                    <a class="btn text-white smooth-link" href="myproducts.php">Product List</a>
                    </button>
                </li>
                <li class="nav-item pr-2">
                    <button class="rounded">
                        <a class="btn text-white smooth-link" href="process-orders.php">Delivery (<?php echo $purchaseCount; ?>)</a>
                    </button>
                </li>
                <li class="nav-item pr-2">
                    <div class="dropdown pr-2">
                        <a class="btn text-white dropdown-toggle" href="#" id="dropdownMenuLink"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Account
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink"
                             id="userDropdown">
                            <?php if ($isAuthenticated || isset($_SESSION['seller_id'])): ?>
                                <a class="dropdown-item smooth-link" id="logoutLink" href="?logout=1"><i class="fa fa-sign-out" aria-hidden="true"></i>
                                &nbsp;Logout</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

</script>