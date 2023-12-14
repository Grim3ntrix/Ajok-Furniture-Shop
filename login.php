<?php
session_start();
require_once 'connection.php';

if (isset($_POST['submit'])) {
  $email = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  
  $sql = "SELECT * FROM users WHERE email=? AND password_hash=?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ss", $email, $password);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['id'] = $row['id'];
    $_SESSION['email'] = $row['email'];

    // Remember me functionality
    if (isset($_POST['remember'])) {
      $_SESSION['remembered_email'] = $email;
    } else {
      unset($_SESSION['remembered_email']);
    }
    header('Location: index.php');
    exit();
  } else {
    $error = "Invalid email and/or password, please try again";
  }
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
      <title>Login now to start shopping | Ajok Furniture Shop Online</title>
      <meta name="keywords" content="ApplianceMart Online Shopping">
      <meta name="description" content="This e-commerce website sells appliances online">
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
   </head>
   <!-- body -->
   <body class="" style="background-color: #73A500; display: flex; flex-direction: column; min-height: 100vh;">
   <!-- header -->
      <header class="sticky-top ">
        <?php include('navbar.php'); ?>
      </header>
    <!--  section -->
    
    <div class="container">
    <form action="login.php" method="POST">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-sm-12" style="background-color:#fafafa; border-radius:5px; padding:24px; width:95%; height:50%; margin-top:100px;">
                <?php if (isset($error)) { ?>
                    <div class="alert-danger alert" role="alert"><?php echo $error; ?></div>
                <?php } ?>
                <h3 class="text-center text-success">Welcome back, Log in now!</h3><br>
                <div class="form-group text-left">
                    <label class="text-success">Email</label>
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
                <div class="form-group text-left" style="display: flex; justify-content: space-between;">
                    <div class="remember">
                        <input type="checkbox" name="remember" class="text-info">
                        <label for="remember" class="text-success">Remember Me</label>
                    </div>
                    <a href="forgot.php" class="text-success" id="forgot">Forgot Password?</a>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-success btn-md center" value="Login">
                </div>
                <br>
                <div class="text-center">
                  <p class="signup-messsage">No Account? <a href="javascript:void(0);" onclick="redirectToSignup()" class="text-success">Sign Up</a></p>
                </div>
            </div>
        </div><br><br>
    </form>
</div>
      <footer>
        <?php include('footer.php'); ?>
      </footer>
      <!-- end footer -->
      <!-- Signup Link -->
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
      <script>
        function redirectToSignup() {
          window.location.href = 'signup.php';
        }
      </script>
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
   </body>
</html>
