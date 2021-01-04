<!DOCTYPE html>



<?php

require_once "config.php";

$name = $surname  = $email = $password = $confirm_password = "";
$name_err = $surname_err  = $email_err = $password_err = $confirm_password_err = "";

// REGISTER

if($_SERVER["REQUEST_METHOD"] == "POST") {
  // Name validation

  if(empty($_POST['name'])) {
    $name_err = "Please enter a name.";
  }
  else {
    $name = test_input($_POST['name']);
  }

  // Surname validation

  if(empty($_POST['surname'])) {
    $surname_err = "Please enter a surname.";
  }
  else {
    $surname = test_input($_POST['surname']);
  }

  // Password Validation

  if(empty($_POST["password"])){
      $password_err = "Please enter a password.";
  } elseif(strlen(test_input($_POST["password"])) < 6){
      $password_err = "Password must have atleast 6 characters.";
  } else{
      $password = test_input($_POST["password"]);
  }

  if(empty($_POST["password2"])){
      $confirm_password_err = "Please confirm password.";
  } else{
      $confirm_password = test_input($_POST["password2"]);
      if(empty($password_err) && ($password != $confirm_password)){
          $confirm_password_err = "Password did not match.";
      }
  }

  // E-mail Validation

  if(empty($_POST["email"])) {
    $email_err = "Please enter an e-mail.";
  }
  else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_err = "Invalid email format";
    }
  }

  if(empty($name_err) && empty($surname_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){

    $sql_statement = "INSERT INTO person(name, surname, email, pass) VALUES (?, ?, ?, ?)";

    if($stmt = mysqli_prepare($db, $sql_statement)){
      // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_name, $param_surname, $param_email, $param_password);

            // I did this so if we need to edit the data we can interfere these variables.
            $param_name = $name;
            $param_surname = $surname;
            $param_email = $email;
            $param_password = $password; // raw form

            if(mysqli_stmt_execute($stmt)){
               // Redirect to login page
               header("location: index.php");
            } else{
               echo "Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);

    }

    mysqli_close($db);
  }
}


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

?>



<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>E Store - eCommerce HTML Template</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="eCommerce HTML Template Free Download" name="keywords">
        <meta content="eCommerce HTML Template Free Download" name="description">

        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap" rel="stylesheet">

        <!-- CSS Libraries -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="lib/slick/slick.css" rel="stylesheet">
        <link href="lib/slick/slick-theme.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>
        <!-- Top bar Start -->
        <div class="top-bar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <i class="fa fa-envelope"></i>
                        support@email.com
                    </div>
                    <div class="col-sm-6">
                        <i class="fa fa-phone-alt"></i>
                        +012-345-6789
                    </div>
                </div>
            </div>
        </div>
        <!-- Top bar End -->

        <!-- Nav Bar Start -->
        <div class="nav">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                    <a href="#" class="navbar-brand">MENU</a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto">
                            <a href="index.php" class="nav-item nav-link">Home</a>
                            <a href="product-list.php" class="nav-item nav-link">Products</a>
                            <a href="product-detail.php" class="nav-item nav-link">Product Detail</a>
                            <a href="cart.php" class="nav-item nav-link">Cart</a>
                            <a href="checkout.php" class="nav-item nav-link">Checkout</a>
                            <a href="my-account.php" class="nav-item nav-link">My Account</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle active" data-toggle="dropdown">More Pages</a>
                                <div class="dropdown-menu">
                                    <a href="wishlist.php" class="dropdown-item">Wishlist</a>
                                    <a href="login.php" class="dropdown-item active">Login & Register</a>
                                    <a href="contact.php" class="dropdown-item">Contact Us</a>
                                </div>
                            </div>
                        </div>
                        <div class="navbar-nav ml-auto">
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">User Account</a>
                                <div class="dropdown-menu">
                                    <a href="#" class="dropdown-item">Login</a>
                                    <a href="#" class="dropdown-item">Register</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Nav Bar End -->

        <!-- Bottom Bar Start -->
        <div class="bottom-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="logo">
                            <a href="index.php">
                                <img src="img/logo.png" alt="Logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="search">
                            <input type="text" placeholder="Search">
                            <button><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="user">
                            <a href="wishlist.php" class="btn wishlist">
                                <i class="fa fa-heart"></i>
                                <span>(0)</span>
                            </a>
                            <a href="cart.php" class="btn cart">
                                <i class="fa fa-shopping-cart"></i>
                                <span>(0)</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bottom Bar End -->

        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Products</a></li>
                    <li class="breadcrumb-item active">Login & Register</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->

        <!-- Login Start -->
        <div class="login">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <form class="register-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>First Name</label>
                                    <input class="form-control <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>" type="text" name="name" placeholder="First Name" value="<?php echo $name;?>">
                                    <span class="help-block"><?php echo $name_err; ?></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Last Name</label>
                                    <input class="form-control <?php echo (!empty($surname_err)) ? 'has-error' : ''; ?>" type="text" name="surname" placeholder="Last Name" value="<?php echo $surname;?>">
                                    <span class="help-block"><?php echo $surname_err; ?></span>
                                </div>
                                <div class="col-md-6">
                                    <label>E-mail</label>
                                    <input class="form-control <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>" type="text" name="email" placeholder="E-mail" value="<?php echo $email;?>">
                                    <span class="help-block"><?php echo $email_err; ?></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Password</label>
                                    <input class="form-control <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>" type="text" name="password" placeholder="Password">
                                    <span class="help-block"><?php echo $password_err; ?></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Retype Password</label>
                                    <input class="form-control <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>" type="text" name="password2" placeholder="Password">
                                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <form class="login-form" action="login-api.php" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>E-mail</label>
                                    <input class="form-control" type="text" name="email" placeholder="E-mail" value="<?php echo $email;?>">
                                </div>
                                <div class="col-md-6">
                                    <label>Password</label>
                                    <input class="form-control" type="text" name="password" placeholder="Password">
                                </div>
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="newaccount">
                                        <label class="custom-control-label" for="newaccount">Keep me signed in</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Login End -->

        <!-- Footer Start -->
        <div class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h2>Get in Touch</h2>
                            <div class="contact-info">
                                <p><i class="fa fa-map-marker"></i>123 E Store, Los Angeles, USA</p>
                                <p><i class="fa fa-envelope"></i>email@example.com</p>
                                <p><i class="fa fa-phone"></i>+123-456-7890</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h2>Follow Us</h2>
                            <div class="contact-info">
                                <div class="social">
                                    <a href=""><i class="fab fa-twitter"></i></a>
                                    <a href=""><i class="fab fa-facebook-f"></i></a>
                                    <a href=""><i class="fab fa-linkedin-in"></i></a>
                                    <a href=""><i class="fab fa-instagram"></i></a>
                                    <a href=""><i class="fab fa-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h2>Company Info</h2>
                            <ul>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Terms & Condition</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h2>Purchase Info</h2>
                            <ul>
                                <li><a href="#">Pyament Policy</a></li>
                                <li><a href="#">Shipping Policy</a></li>
                                <li><a href="#">Return Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row payment align-items-center">
                    <div class="col-md-6">
                        <div class="payment-method">
                            <h2>We Accept:</h2>
                            <img src="img/payment-method.png" alt="Payment Method" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="payment-security">
                            <h2>Secured By:</h2>
                            <img src="img/godaddy.svg" alt="Payment Security" />
                            <img src="img/norton.svg" alt="Payment Security" />
                            <img src="img/ssl.svg" alt="Payment Security" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Footer Bottom Start -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 copyright">
                        <p>Copyright &copy; <a href="https://htmlcodex.com">HTML Codex</a>. All Rights Reserved</p>
                    </div>

                    <div class="col-md-6 template-by">
                        <p>Template By <a href="https://htmlcodex.com">HTML Codex</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Bottom End -->

        <!-- Back to Top -->
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/slick/slick.min.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
    </body>
</html>