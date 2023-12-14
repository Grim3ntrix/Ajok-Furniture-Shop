<?php
session_start();
require_once 'connection.php';

if (isset($_POST['submit'])) {
    $shopname = mysqli_real_escape_string($conn, $_POST['myshopname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $dateOfBirth = mysqli_real_escape_string($conn, $_POST['dateOfBirth']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $current_time = date('Y-m-d H:i:s');

    // Check if the email is already taken
    $stmt = $conn->prepare("SELECT * FROM sellers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $unavailable = "Account is already in use, please try again";
        $alert_type = "alert-danger";
    } else {
        // Insert new seller data into the table
        $stmt = $conn->prepare("INSERT INTO sellers (seller_shop_name, email, password_hash, address, date_of_birth, Gender, registration_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $shopname, $email, $password, $address, $dateOfBirth, $gender, $current_time);

        if ($stmt->execute()) {
            $account = "New account created successfully! Login Now";
            $alert_type = "alert-success";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    mysqli_close($conn);
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
    <title>Sign up and start selling | Ajok Furniture Shop Online</title>
    <meta name="keywords" content="ApplianceMart Online Shopping">
    <meta name="description" content="This e-commerce website sells appliances online">
    <meta name="author" content="Richard Samberi">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif"/>
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <!--[if lt IE 9]-->
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><!--[endif]-->
</head>
<!-- body -->
<body style="background-color: #73A500; display: flex; flex-direction: column; min-height: 100vh;">
<!-- header -->
<header class="sticky-top ">
    <?php include('navbar.php'); ?>
</header>
<!--  section -->
<main style="flex: 1;">
    <div class="container">
        <form action="sellnow.php" method="POST"><br>
            <div class="row justify-content-center">
                    <div class="col-lg-6 col-sm-12" style="background-color:#fafafa; border-radius:5px; padding:24px; width:95%;">
                        <?php if (isset($account)): ?>
                            <div class="alert <?php echo $alert_type; ?>"><?php echo $account; ?></div>
                        <?php endif; ?>
                        <?php if (isset($unavailable)): ?>
                            <div class="alert <?php echo $alert_type; ?>"><?php echo $unavailable; ?></div>
                        <?php endif; ?>
                        <h3 class="text-center text-success" style="margin-top:8px;">Be a Seller, Sign Up!</h3><br>
                        <div class="form-group text-left">
                            <label for="myshopname" class="text-success">Shop Name</label>
                            <div class="input-group">
                                <input type="text" name="myshopname" class="form-control" placeholder="Shop Name" required>
                            </div>
                        </div>
                        <div class="form-group text-left">
                            <label for="email" class="text-success">Email</label>
                            <div class="input-group">
                                <input type="text" name="email" class="form-control" placeholder="ex. myshop@gmail.com" required>
                            </div>
                        </div>
                        <div class="form-group text-left">
                            <label for="password" class="text-success">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-group text-left">
                            <label for="address" class="text-success">Address</label>
                            <div class="input-group">
                                <input type="text" name="address" class="form-control" placeholder="Address" required>
                            </div>
                        </div>
                        <div class="form-group text-left">
                            <label for="dateOfBirth" class="text-success">Date of Birth</label>
                            <div class="input-group">
                                <input type="date" name="dateOfBirth" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group text-left">
                            <label for="gender" class="text-success">Gender</label>
                            <div class="input-group">
                                <select name="gender" class="form-control" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-success btn-md center" value="Submit">
                        </div>
                        <div class="text-center">
                            <!--<p class="signup-messsage">Already a seller? <a href="login-seller.php" class="text-success">Login</a></p>
                        --></div>
                    </div>
            </div><br><br>
        </form>
    </div>
</main>
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
</body>
</html>
