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

// Get the product ID from the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch the product from the database
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $productId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);

    if (!$product) {
        // Redirect to the products page if the product does not exist
        header('Location: myproducts.php');
        exit();
    }
} else {
    // Redirect to the products page if the product ID is not provided
    header('Location: myproducts.php');
    exit();
}

// Update the product logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];

    // Check if a new image file was uploaded
    if ($_FILES['image']['error'] === 0) {
        $tempFilePath = $_FILES['image']['tmp_name'];
        $uploadPath = 'product_images/' . $_FILES['image']['name'];

        // Delete the old image file if it exists
        if (!empty($product['image'])) {
            $oldImagePath = 'product_images/' . $product['image'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Move the uploaded file to the desired location
        move_uploaded_file($tempFilePath, $uploadPath);
        $image = $_FILES['image']['name'];
    } else {
        // Use the existing image if no new file was uploaded
        $image = $product['image'];
    }

    // Update the product in the database
    $sql = "UPDATE products SET product_title = ?, product_category = null, product_condition = null, price = ?, quantity = ?, description = ?, image = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssdssi", $productName, $price, $quantity, $description, $image, $productId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Redirect to the products page after updating the product
    header('Location: myproducts.php');
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
    <title>Update Product | Ajok Furniture Shop Online</title>
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
            <div class="row">
                <div class="col-12 bg-white rounded">
                    <div style="background-color: #ffffff;">
                        <div class="card-body">
                            <h3>Edit Product</h3>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $productId; ?>" enctype="multipart/form-data">
                                <div class="form-group">
                                    <?php if (!empty($product['image'])): ?>
                                        <div class="mt-2">
                                            <img id="previewImage" src="product_images/<?php echo $product['image']; ?>" class="img-fluid" style="max-height: 200px;">
                                        </div>
                                    <?php endif; ?>
                                    <div class="input-group justify-content-center">
                                        <input type="file" class="custom-file-input" id="image" name="image" onchange="previewFile()">
                                        <label class="input-group-text hov" for="image">Change image...</label>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-sm-12 rounded" style="background-color:#ffffff; padding:15px;"><br>
                <div class="row">
                    <div class="col-sm-6 form-group text-left">
                        <label for="product_name" class="text-success">Product Name</label>
                        <div class="">                        
                            <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product['product_title']; ?>" required>
                        </div>
                    </div>
                    <div class="col-sm-6 form-group text-left">
                        <label for="price" class="text-success">Price</label>
                        <div class="">                          
                            <input type="number" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 form-group text-left">
                        <label for="quantity" class="text-success">Quantity</label>
                        <div class="">     
                            <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $product['quantity']; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 form-group text-left">
                        <label for="description" class="text-success">Description:</label>
                        <div class="">
                            <textarea class="form-control" id="description" name="description" rows="5"><?php echo $product['description'];?></textarea>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success"> Save</button>
                </div>
            </div>
        </div>
    </form>
    </main>
    <footer>
        <?php include('footer.php'); ?>
    </footer>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        function previewFile() {
            const preview = document.getElementById('previewImage');
            const file = document.querySelector('input[type=file]').files[0];
            const reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
    </script>
    <script>
        const isAuthenticated = <?php echo $isAuthenticated ? 'true' : 'false'; ?>;
        $(document).ready(function () {
            if (isAuthenticated) {
                $('#loginLink').hide();
                $('#logoutLink').show();
            } else {
                $('#loginLink').show();
                $('#logoutLink').hide();
            }
        });
    </script>
</body>
</html>