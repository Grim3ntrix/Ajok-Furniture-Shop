<?php
session_start();
require_once 'connection.php';

// Check if the user is authenticated
$isAuthenticatedUser = isset($_SESSION['id']);

// Redirect to the login page if the user is not authenticated
if (!$isAuthenticatedUser) {
    header('Location: login.php');
    exit();
}

// Get the user ID from the session
$userId = $_SESSION['id'];

// Fetch the user's current information from the database to prepopulate the form
$sql = "SELECT * FROM users WHERE id = '$userId'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    // Redirect to a page or show an error message if the user does not exist
}

// Update the user's profile logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password_hash'];
    $contactNumber = $_POST['contact_number'];
    $dateOfBirth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $modeOfPayment = $_POST['mode_of_payment'];
    $Shipping_Address = $_POST['shipping_address'];

    // Validate and sanitize input
    $fullname = mysqli_real_escape_string($conn, $fullname);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $contactNumber = mysqli_real_escape_string($conn, $contactNumber);
    $dateOfBirth = mysqli_real_escape_string($conn, $dateOfBirth);
    $gender = mysqli_real_escape_string($conn, $gender);
    $modeOfPayment = mysqli_real_escape_string($conn, $modeOfPayment);
    $Shipping_Address = mysqli_real_escape_string($conn, $Shipping_Address);

    // Update the user's information in the database
    $sql = "UPDATE users SET username = '$username', fullname = '$fullname', email = '$email', password_hash = '$password', contact_number = '$contactNumber', date_of_birth = '$dateOfBirth', gender = '$gender', mode_of_payment = '$modeOfPayment' ,shipping_address = '$Shipping_Address' WHERE id = '$userId'";
    mysqli_query($conn, $sql);

    // Redirect to the user's profile page after updating the information
    header('Location: edit-profile.php');
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
    <title>Edit Product | Ajok Furniture Shop Online</title>
    <meta name="keywords" content="ApplianceMart Online Shopping">
    <meta name="description" content="This e-commerce website sells appliances online">
    <meta name="author" content="Richard Samberi">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Fancybox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://kit.fontawesome.com/07672f603e.js" crossorigin="anonymous">
</head>

<body class="bg-73A500" style="background-color: #73A500; display: flex; flex-direction: column; min-height: 100vh;">

    <header>
        <?php include('navbar.php'); ?>
    </header>

    <main style="flex: 1;">
        <div class="container mt-3 md-5 p-5">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div style="background-color: #ffffff;">
                        <div style="padding:10px;">
                            <h3 class="text-success" >My Profile</h3>
                        </div>
                        <div class="card-body border border-success-subtle">
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                <div class="row">
                                    <div class="col-sm-6 form-group text-left">
                                        <label for="username" class="text-success">Username</label>
                                        <div class="">
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $user['username']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 form-group text-left">
                                        <label for="fullname" class="text-success">Full Name</label>
                                        <div class="">
                                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full Name" value="<?php echo $user['fullname']; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 form-group text-left">
                                        <label for="email" class="text-success">Email</label>
                                        <div class="">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $user['email']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 form-group text-left">
                                        <label for="email" class="text-success">Password</label>
                                        <div class="">
                                        <input type="password" class="form-control" id="password_hash" name="password_hash" value="<?php echo $user['password_hash']; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 form-group text-left">
                                        <label for="contact_number" class="text-success">Contact Number</label>
                                        <div class="">
                                        <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Contact Number" value="<?php echo $user['contact_number']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 form-group text-left">
                                        <label for="date_of_birth" class="text-success">Date of Birth</label>
                                        <div class="">
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Date of Birth" value="<?php echo $user['date_of_birth']; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 form-group text-left">
                                        <label for="gender" class="text-success">Gender</label>
                                        <div class="">
                                        <select class="form-control" id="gender" name="gender" required>
                                            <option value="male" <?php echo $user['gender'] === 'male' ? 'selected' : ''; ?>>Male</option>
                                            <option value="female" <?php echo $user['gender'] === 'female' ? 'selected' : ''; ?>>Female</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 form-group text-left">
                                        <label for="Shipping_address" class="text-success">Shipping Address</label>
                                        <div class="">
                                        <input type="text" class="form-control" id="shipping_address" name="shipping_address" placeholder="Shipping Address" value="<?php echo $user['shipping_address']; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 form-group text-left">
                                        <label for="Shipping_address" class="text-success">Mode of Payment</label>
                                        <div class="">
                                            <select class="p-1 form-control" style="border-radius: 4px;" name="mode_of_payment" id="mode_of_payment" value="<?php echo $user['mode_of_payment']; ?>" required>
                                                <option value="" selected>Open this select menu</option>
                                                <option value="Cash-On-Delivery" <?php echo $user['mode_of_payment'] === 'Cash-On-Delivery' ? 'selected' : ''; ?> >Cash-On-Delivery</option>
                                                <option value="G-cash" disabled>G-cash</option>
                                                <option value="Paypal" disabled>Paypal</option>
                                                <option value="Bank Transfer" disabled>Bank-Transfer</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success" style="width: 100%;"> Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <?php include('footer.php'); ?>
    </footer>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>