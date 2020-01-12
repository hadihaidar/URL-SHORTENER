
<?php
include "connection.php";
session_start();
if (isset($_SESSION['name'])) {
    header("location:press.php");
}
?>
<html>

<head>
    <title>URL SHORTENER</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="img/Doctors.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="style/stylesheet.css">
</head>

<body>

    <!-- THE HEADER -->
    <header>
        <div class="container-fluid custom-container" style="margin:0px">
            <div class="row no_row row-header">
                <div class="brand-be" style="margin:0px">
                    <a href="index.php">
                        <img class="logo-c active be_logo" src="img/Doctors.png" style="width:121px;height:70px" ; alt=" logo">
                    </a>
                </div>

                <div class="login-header-block">
                    <div class="login_block">
                        <a id="blackit" class="btn-login btn color-1 size-2 hover-2" href=""><i class="fa fa-user"></i>
                            Log in</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <div id="content-block">
        <div class="head-bg">
            <div class="head-bg-img"></div>
            <div class="head-bg-content">
                <h1>Welcome to the URL shortener</h1>
                <p>Paste..Compress..And Share</p>
                <a class="be-register btn color-1 size-1 hover-1"><i class="fa fa-lock"></i>sign up now</a>
            </div>
        </div>
    </div>


    <div class="be-fixed-filter"></div>

    <div class="large-popup login">
        <div class="large-popup-fixed"></div>
        <div class="container large-popup-container">
            <div class="row">
                <div class="col-md-8 col-md-push-2 col-lg-6 col-lg-push-3  large-popup-content">
                    <div class="row">
                        <div class="col-md-12">
                            <i class="fa fa-times close-button"></i>
                            <h5 class="large-popup-title">Log in</h5>
                        </div>
                        <form action="login.php" method="POST" class="popup-input-search">
                            <div class="col-md-6">
                                <input class="input-signtype" name="email" type="email" required="" placeholder="Your email">
                            </div>
                            <div class="col-md-6">
                                <input class="input-signtype" type="password" name="password" required="" placeholder="Password">
                            </div>
                            <div class="col-xs-6">
                                <!-- <a href="forget.php" class="link-large-popup">Forgot password?</a>-->
                            </div>
                            <div class="col-xs-6 for-signin">
                                <input name='login' type="submit" class="be-popup-sign-button" value="SIGN IN">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="large-popup register">
        <div class="large-popup-fixed"></div>
        <div class="container large-popup-container">
            <div class="row">
                <div class="col-md-10 col-md-push-1 col-lg-8 col-lg-push-2 large-popup-content">
                    <div class="row">
                        <div class="col-md-12">
                            <i class="fa fa-times close-button"></i>
                            <h5 class="large-popup-title">Register</h5>
                        </div>
                        <form action="./" class="popup-input-search" method="POST">
                            <div class="col-md-6">
                                <input class="input-signtype" type="text" name='first' required="" placeholder="First Name">
                            </div>
                            <div class="col-md-6">
                                <input class="input-signtype" type="text" required="" name='last' placeholder="Last Name">
                            </div>
                            <div class="col-md-12">
                                <input class="input-signtype" type="email" required="" name='email' placeholder="Email">
                            </div>
                            <div class="col-md-12">
                                <input class="input-signtype" type="password" required="" name='password' placeholder="Password">
                            </div>
                            <div class="col-md-6 for-signin">
                                <input type="submit" name='submit' class="be-popup-sign-button" value="SIGN UP">
                                <?php
                                if (isset($_POST["submit"])) {
                                    $first = $db->quote($_POST["first"]);
                                    $last =  $db->quote($_POST["last"]);
                                    $email = $db->quote($_POST["email"]);
                                    $password = $_POST["password"];
                                    $password = $db->quote(md5($password));
									$id = $db->quote(md5(uniqid().uniqid()));
                                    $query = $db->exec("INSERT INTO users VALUES ($first, $last,$email,$password,$id);");
                                    if ($query) {
                                        echo ('<script>alert("Account successfully created")</script>');
                                    } else {
                                        echo ('<script>alert("Something went wrong please try again")</script>');
                                    }
                                }
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS	 -->
    <script src="script/jquery-2.1.4.min.js"></script>
    <script src="script/jquery-ui.min.js"></script>
    <script src="script/bootstrap.min.js"></script>
    <script src="script/idangerous.swiper.min.js"></script>
    <script src="script/jquery.mixitup.js"></script>
    <script src="script/jquery.viewportchecker.min.js"></script>
    <script src="script/filters.js"></script>
    <script src="script/global.js"></script>
</body>


</html>