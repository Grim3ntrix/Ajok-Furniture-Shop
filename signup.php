<?php
session_start();
require_once 'connection.php';

if (isset($_POST['submit'])) {
    $email = $_POST['username'];
    $password = $_POST['password'];
    $dateOfBirth = $_POST['birthday'];
    $gender = $_POST['gender'];
    $current_time = date('Y-m-d H:i:s');

    // Validate and sanitize input
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $dateOfBirth = mysqli_real_escape_string($conn, $dateOfBirth);
    $gender = mysqli_real_escape_string($conn, $gender);

    // Check if email is empty
    if (empty($email)) {
        $error = "Email field is required";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $unavailable = "Account is already in use, please try again";
            $alert_type = "alert-danger";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (email, password_hash, date_of_birth, gender, created_at) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $email, $password, $dateOfBirth, $gender, $current_time);

            if ($stmt->execute()) {
                $account = "New account created successfully! Login Now";
                $alert_type = "alert-success";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    }

    $stmt->close();
    $conn->close();
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
      <title>Sign up today! | Ajok Furniture Shop Online</title>
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
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <!--[if lt IE 9]-->
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><!--[endif]-->
   </head>
   <!-- body -->
   <body class="" style="background-color: #73A500; display: flex; flex-direction: column; min-height: 100vh;">
      <!-- header -->
      <header class="sticky-top ">
         <?php include('navbar.php'); ?>
      </header>

        <main style="flex: 1;">
            <div class="container">
                <form action="signup.php" method="POST">
                    <div class="row justify-content-center">
                    <div class="col-lg-6 col-sm-12" style="background-color:#fafafa; border-radius:5px; padding:24px; height:70%; width:95%; margin-top:100px;">
                        <?php if (isset($account)) { ?>
                            <div class="alert <?php echo $alert_type; ?> alert-dismissible fade show" role="alert">
                                <?php echo $account; ?>
                            </div>
                        <?php } else if (isset($unavailable)) { ?>
                            <div class="alert <?php echo $alert_type; ?> alert-dismissible fade show" role="alert">
                                <?php echo $unavailable; ?>
                            </div>
                        <?php } ?>
                            <h3 class="text-center text-success">Create a new account!</h3>
                            <div class="form-group text-left">
                                <label class="text-success">Email</label>
                                <div class="input-group">
                                    <input type="email" name="username" class="form-control" placeholder="example@gmail.com" required>
                                </div>
                            </div>
                            <div class="form-group text-left">
                                <label class="text-success">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <label for="Birthday" class="text-success">Birthday:</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" name="birthday" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <label for="gender" class="text-success">Gender:</label>
                                        <div class="input-group">
                                            <select name="gender" class="form-control" required>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-success btn-md center" value="Sign Up">
                            </div>
                                <div class="text-center">
                                <p class="signup-messsage">Have an account? <a href="javascript:void(0);" onclick="redirectToLogin()" class="text-success">Login</a></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
      <footer>
        <?php include('footer.php'); ?>
      </footer>
            <!-- end footer -->
            <!-- Login Link -->
      <script>
            function redirectToLogin() {
                window.location.href = 'login.php';
            }
        </script>

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
