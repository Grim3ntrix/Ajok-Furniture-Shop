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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize form data
    $product_name = isset($_POST['product_name']) ? trim($_POST['product_name']) : '';
    $category = isset($_POST['category']) ? mysqli_real_escape_string($conn, $_POST['category']) : null;
    $condition = isset($_POST['condition']) ? mysqli_real_escape_string($conn, $_POST['condition']) : "";
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    // Check if required fields are not empty
    if (empty($product_name) || empty($price) || empty($quantity)) {
        $error = "Please fill in all required fields.";
    } else {
        $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
        $image_tmp = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : '';

        // Move the uploaded file to a desired location
        move_uploaded_file($image_tmp, "product_images/$image");

        // Get the seller ID and shop name of the current seller
        $sellerID = $_SESSION['seller_id'];
        $sqlShop = "SELECT id, seller_shop_name FROM sellers WHERE id = ?";
        $stmtShop = mysqli_prepare($conn, $sqlShop);
        mysqli_stmt_bind_param($stmtShop, "i", $sellerID);
        mysqli_stmt_execute($stmtShop);
        mysqli_stmt_bind_result($stmtShop, $seller_id, $shopName);
        mysqli_stmt_fetch($stmtShop);
        mysqli_stmt_close($stmtShop);

        // Save the form data to the database
        $sql = "INSERT INTO products (seller_id, seller_shop_name, product_title, product_category, product_condition, price, quantity, image, description) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isssssdss", $seller_id, $shopName, $product_name, $category, $condition, $price, $quantity, $image, $description);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Product added successfully
            $message = "Product added successfully.";
            
            header('Location: myproducts.php');
        exit();
        } else {
            // Failed to add product
            $error = "Failed to add product. Please try again.";
        }
    }
}
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
    <title>Manage your Shop and Earn! | Ajok Furniture Shop Online</title>
    <meta name="keywords" content="ApplianceMart Online Shopping">
    <meta name="description" content="This e-commerce website sell appliances online">
    <meta name="author" content="Richard Samberi">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <!--[if lt IE 9]-->
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <!--[endif]-->
    <script src="https://kit.fontawesome.com/07672f603e.js" crossorigin="anonymous"></script>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .hov{
            background-color: #027cff;
            color: #ffffff;
            border: none; 
        }
        .hov:hover {
            background-color: #0069D9;
            color: #ffffff;
            }

        /* CSS for placing Font Awesome icons inside the input fields */
        .input-group .input-group-text {
            background-color: #f8f9fa;
        }

        .input-group .input-group-text i {
            margin-right: 5px;
        }

        /* CSS for placeholder color */
        ::placeholder {
            color: #aaa;
        }
        .form-group{
            padding:10px;
        }
    </style>
</head>
<body style="background-color: #73A500; display: flex; flex-direction: column; min-height: 100vh;">
    <header>
        <?php include('navbar-dashboard.php'); ?>
    </header>

    <div class="container mt-3">
        <form action="seller-dashboard.php" method="POST" enctype="multipart/form-data">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-sm-12 rounded" style="background-color:#ffffff; padding:15px;"><br>
                    <div class="banner" style="padding:10px;">
                        <h3 class="text-success">Add New Product</h3>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 form-group text-left">
                            <label for="product-name" class="text-success">Product Name:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="product-name" placeholder="Product Name" name="product_name" required>
                            </div>
                        </div>
                        <div class="col-sm-4 form-group text-left">
                            <label for="price" class="text-success">Price:</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="price" name="price" placeholder="₱00.00" min="0" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-sm-4 form-group text-left">
                            <label for="quantity" class="text-success">Quantity:</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="0" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group text-left">
                            <label for="description" class="text-success">Description:</label>
                            <div class="input-group">
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Please add your product description here..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group bg-secondary">                                       
                                <input type="file" name="image" id="image">
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-block">Upload Now</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!--  footer -->
    <footer>
    <?php include('footer.php'); ?>
    </footer>
    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- Script to preview the selected image -->
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image").change(function () {
            previewImage(this);
        });
    </script>
</body>
</html>
