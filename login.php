<?php
session_start();
include('server.php');

// Initialize variables
$username = "";
$errors = array();

// If the login form is submitted
if (isset($_POST['submit'])) {
    // Receive all input values from the form
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Check if admin credentials are entered
    // Check if admin credentials are entered
    if ($username === 'admin') {
        // Check if password matches
        if ($password === 'adminpassword') {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in as admin";
            header('location: view.php');
            exit(); // Ensure that script stops execution after redirect
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    } else {
        // Login as regular user
        $password = md5($password);
        $query = "SELECT * FROM `register` WHERE `username`='$username' AND `password_1`='$password'";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) {
            $fetchUserDetails = mysqli_fetch_assoc($results);
            $_SESSION['first_name'] = $fetchUserDetails['first_name'];
            $_SESSION['last_name'] = $fetchUserDetails['last_name'];
            $_SESSION['email'] = $fetchUserDetails['email'];
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
            exit(); // Ensure that script stops execution after redirect
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="signin-content">
                <div class="signin-image">
                    <figure><img src="HMSLOGO.png" alt="sing up image"></figure>
                    <a href="register.php" class="signup-image-link">Create an account</a>
                </div>

                <div class="signin-form">
                    <h2 class="form-title">Login</h2>
                    <form method="POST" class="register-form" action="login.php" id="login-form">
                        <?php include('errors.php'); ?>
                        <div class="form-group">
                            <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text" name="username" id="username" required="_required" placeholder="username" />
                        </div>
                        <div class="form-group">
                            <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="password" required="_required" placeholder="Password" />
                        </div>

                        <div class="form-group form-button">
                            <input type="submit" name="submit" id="submit" class="form-submit" value="Log in" />
                        </div>
                    </form>
                    <div class="social-login">
                        <span class="social-label">Or login with</span>
                        <ul class="socials">
                            <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                            <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                            <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>