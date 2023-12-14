<?php
session_start();
require_once 'connection.php';

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the login is for a seller
    $stmt = $conn->prepare("SELECT * FROM sellers WHERE email = ? AND password_hash = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['seller_id'] = $row['id'];
        $_SESSION['seller_username'] = $row['email'];

        header('Location: seller-dashboard.php');
        exit();
    } else {
        $error = "Invalid email and/or password, please try again";
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
  <title>Login now and start selling | Ajok Furniture Shop Online</title>
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
  <link rel="icon" href="images/fevicon.png" type="image/gif" />
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
    <main style="flex: 1;">
        <!--  section -->
        <div class="container">
            <form action="login-seller.php" method="POST">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-sm-12" style="background-color:#fafafa; border-radius:5px; padding:24px; width:95%; height:50%; margin-top:100px;">
                        <?php if (isset($error)) { ?>
                            <div class="alert-danger alert" role="alert"><?php echo $error; ?></div>
                        <?php } ?>
                        <h3 class="text-center text-success">Ajok Furniture Shop</h3><br>
                        <div class="form-group text-left">
                            <label class="text-success">Username</label>
                            <div class="input-group">
                                <input type="email" name="username" class="form-control" placeholder="example@gmail.com" required value="<?php echo isset($_SESSION['remembered_username']) ? $_SESSION['remembered_username'] : ''; ?>">
                            </div>
                        </div>
                        <div class="form-group text-left">
                            <label class="text-success">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                            </div>
                        </div>
                        <div class="form-group" style="display: flex; justify-content: space-between;">
                            <div class="remember">
                                <input type="checkbox" name="remember" class="text-success">
                                <label for="remember" class="text-success">Remember Me</label>
                            </div>
                            <a href="forgot.php" class="text-success" id="forgot">Forgot Password?</a>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-success btn-md center" value="Login">
                        </div>
                        <div class="text-center">
                            <!-- <p class="signup-message">Be a Seller? <a href="sellnow.php" class="text-success">Sign Up</a></p>
                        --></div>
                    </div>
                </div>
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