<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="favicon.png">

  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap4" />

		<!-- Bootstrap CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
		<link href="css/tiny-slider.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<title>Bookly.</title>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="js/login.js"></script>
<!------ Include the above in your HEAD tag ---------->
</head>

<!-- Start Hero Section -->
<div class="hero" style="height: 100vh; display: flex; justify-content: center; align-items: center;">
  <div class="container" style="height: 100%; display: flex; flex-direction: column; justify-content: center;">
		<div class="row justify-content-between">


<?php
session_start(); 
include("conn.php");

function searchUser($email, $password) {
    global $connection;
    $email = $connection->real_escape_string($email);
    $password = $connection->real_escape_string($password);
    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $connection->query($query);
    return $result->num_rows > 0;
}

function createUser($name, $email, $password) {
    global $connection;
    $name = $connection->real_escape_string($name);
    $email = $connection->real_escape_string($email);
    $password = $connection->real_escape_string($password);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        return false;
    } else {
        $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        return $connection->query($query);
    }
}

$warningMessage = "";

if (isset($_POST['submit-login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (searchUser($email, $password)) {
        $_SESSION['email'] = $email;
        header("Location: index.php");
        exit();
    } else {
        $warningMessage = "This account does not exist.";
    }
}

if (isset($_POST['submit-register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (searchUser($email, $password)) {

        $warningMessage = "There is already an account with this email address.";
    } else {
        if (createUser($name, $email, $password)) {
            $_SESSION['email'] = $email; 
            header("Location: index.php");
            exit();
        } else {
            $warningMessage = "Registration failed. Try again.";
        }
    }
}
?>


<div class="col-lg-5">
    <div class="panel panel-login">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-6">
                    <a href="#" class="active" id="login-form-link">Login</a>
                </div>
                <div class="col-xs-6">
                    <a href="#" id="register-form-link">Register</a>
                </div></div></div>

        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <form id="login-form" action="login.php" method="post" role="form" style="display: block;">
                        <div class="form-group">
                            <input type="email" name="email" id="email-login" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password-login" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="form-group text-center">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember"> Remember Me</label>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit-login" class="form-control btn btn-login" value="Log In">
                        </div>
                        <div class="form-group text-center">
                        </div>
						<?php if (!empty($warningMessage)) : ?>
                <div class="warning"><?php echo $warningMessage; ?></div>
        <?php endif; ?>
                    </form>
                    <form id="register-form" action="login.php" method="post" role="form" style="display: none;">
                        <div class="form-group">
                            <input type="text" name="name" id="name-register" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" id="email-register" class="form-control" placeholder="Email Address" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password-register" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit-register" class="form-control btn btn-register" value="Register Now">
                        </div>
						<?php if (!empty($warningMessage)) : ?>
                <div class="warning"><?php echo $warningMessage; ?></div></form>
        <?php endif; ?>
                    </form></div></div></div></div></div>
			
                <div class="col-lg-7">
				<div class="hero-img-wrap">
					<img src="images/couch.png" class="img-fluid" alt="Couch Image">
				</div>
			</div>

		</div>
	</div>
</div>
