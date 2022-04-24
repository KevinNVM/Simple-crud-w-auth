<?php 
// Connect database
require 'Function-Lib/functions.php';

session_start();

// check if cookies exist
if (isset($_COOKIE[hash('sha256', 'id')]) && isset($_COOKIE['PHPCOOKEY'])) {
  $id = $_COOKIE[hash('sha256', 'id')];
  $key = $_COOKIE['PHPCOOKEY'];

  // check if cookies match
  $result = mysqli_query($conn, "SELECT user_username FROM user WHERE user_id = '$id'");
  $data = mysqli_fetch_assoc($result);

  if ($key === hash('gost-crypto', $data['user_username'])) {
    // set session
    $_SESSION['displayName'] = $data['user_username'];
    $_SESSION['logged'] = true;
  }

}

// check for session logged
if (isset($_SESSION['logged']) === true) {
  // redirect to main page
  header("Location: index.php");
}

// check for login button
if (isset($_POST['submit'])) {
  $username = mysqli_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // check if input is empty 
  if ($username !== '' && $password !== '') {
  
 
  // check for username
  $query = mysqli_query($conn, "SELECT * FROM user WHERE user_username = '$username'");
  $data = mysqli_fetch_assoc($query);

  if (mysqli_num_rows($query) === 1) {  
    // check for password
    if (password_verify($password, $data['user_password'])) {
      // redirect or set cookies

      // check if user clicked remember me input 
      if (isset($_POST['rememberme'])) {
        // set cookies for 30 days
        setcookie(hash('sha256', 'id'), $data['user_id'], time() + 86400 * 30);
        setcookie('PHPSESSCKEY', hash('gost-crypto', $data['user_username']), time() + 86400 * 30);     
      }
    
    // set session for main page
    $_SESSION['logged'] = true;
    $_SESSION['displayName'] = $username;

    // redirect user to main page
    header("Location: index.php");

    } else {
      // display error message
    $error = true;
    // send back username to input
    $n = $username;
    }
    
  } else {
    // display error message
    $error = true;
    // send back username to input
    $n = $username;
  }
} else {
  // display error message
  $empty = true;
  // send back username to input
  $n = $username;
}
   }



if (!isset($n)) {
  $n = "";
}


 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css'>
    <link rel="apple-touch-icon" sizes="180x180" href="favico/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favico/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favico/favicon-16x16.png">
	<link rel="manifest" href="favico/site.webmanifest">
  <link rel="stylesheet" type="text/css" href="css/style.css">
	<style type="text/css">
		body {
			background-color: rgb(24,24,24);
		}
    a {
      color: white;
    }
    a:hover {
      color: darkgray;
    }
	</style>
	<title>Login ~ VnPage</title>
</head>
<body>

<!-- BODY -->

	<!-- navbar -->

	<nav class="navbar navbar-lg navbar-dark bg-dark sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><img src="favico/navbarico.png"> VnPage</a>
    <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"><i class="bi bi-list"></i></button>
    <div class="collapse navbar-collapse" id="navbarNav">
    </div>
  </div>
</nav>

	<!-- offcanvas -->
<div class="offcanvas offcanvas-end bg-dark" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title text-white" id="offcanvasWithBothOptionsLabel">Menu</h5>
    <button type="button" class="btn btn-dark text-light" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-x"></i></button>
  </div>
  <div class="offcanvas-body">
    <ul>
      <li class="nav-item">
          <a class="nav-link link-light" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link link-light" href="signup.php">Sign Up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link link-light" href="resetpass.php">Forgot Password</a>
        </li>
    </ul>
  </div>
</div>

	  <br class="user-select-none">
	<!-- /offcanvas -->

	<!-- /navbar -->

  <!-- if user wrong -->
  <?php if (isset($error) === true) { ?>
  <div class="alert mt-2">
  <a id="clsbtn_alert" class="closebtn">&times;</a>  
  <strong>Alert!</strong> Incorrect Username or Password! <a href="resetpass.php">Forgot Your Password</a>?
</div>
<?php unset($error); ?>
<?php }; ?>

<!-- if input empty -->
  <?php if (isset($empty)) : ?>
  <div>
    <div class="alert warning mt-2">
  <a id="clsbtn_notice" class="closebtn">&times;</a>  
  <strong>Notice!</strong> Enter your email and password
</div>
  </div>
  <?php unset($empty); ?>
<?php endif; ?>


  <!-- use features -->
  <?php if (isset($_SESSION['required'])) { ?>
  <div class="alert info">
  <a id="clsbtn_info" class="closebtn">&times;</a>  
  <strong>Info!</strong> Please Log in to your account or <a href="signup.php">Sign up</a> To use availabe Features
</div>
<?php unset($_SESSION['required']) ?>
<?php }; ?>


	<!-- lbody -->


	<div class="container-sm text-white mt-5 mb-5 d-flex justify-content-center">
		<form method="post">
  <div class="mb-3">
    <label for="usernameinput" class="form-label">Username</label>
    <input style="width: 35vh;" value="<?= $n  ?>" type="text" name="username" class="form-control" id="usernameinput" aria-describedby="usernameHelp" placeholder="Type in your username here">
    <div id="usernameHelp" class="form-text">Forgot your username? <a href="findacc.php">Find Your Account</a></div>
  </div>
  <div class="mb-2">
    <label for="passinput" class="form-label">Password</label>
    <label id="labelshowpass" class="ps-1 form-check-label user-select-none float-end fs-5" for="showpass"><i class="bi bi-eye"></i></label>
    <input type="checkbox" class="form-check-input float-end d-none" id="showpass" onclick="showPass()">
    <input style="width: 35vh;" type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Keep your password secret!" autocomplete="off">
    <div id="usernameHelp" class="form-text"><a href="resetpass.php">Forgot Password ?</a></div>
  </div>
  <div class="mb-3 form-check">
    <div>
    <input type="checkbox" name="rememberme" class="form-check-input" id="remember" checked>
    <label class="form-check-label user-select-none" for="remember"><a title="Clicking the “Remember Me” box tells the browser to save a cookie so that you didn't have to login anymore for the next 30 days.">Remember Me</a></label>
    </div>
  </div>
  <div class="text-center">
  <button type="submit" name="submit" class="btn btn-primary ps-5 pe-5">Login</button>
  </div>
</form>
	</div>


	<!-- /lbody -->


<!-- /BODY -->

<!-- Javascript with Popper -->
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
<!-- /Javascript with Popper -->
<script src="ajax/jquery.min.js"></script>
<script src="script.js"></script>
<script type="text/javascript">

  function showPass() {
  var x = document.getElementById("exampleInputPassword1");
  var y = document.getElementById("labelshowpass");
  if (x.type === "password") {
    x.type = "text";
    y.innerHTML = '<i class="bi bi-eye-slash"></i>';
  } else {
    y.innerHTML = '<i class="bi bi-eye"></i>';
    x.type = "password";
  }
}



</script>
</body>
</html>