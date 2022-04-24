<?php 
// start session
session_start();

// prevent user from generating new otp for 1 minutes
// coming soon..


// check if cookies exist
require 'Function-Lib/functions.php';
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
  $id = $_COOKIE['id'];
  $key = $_COOKIE['key'];

  // check if cookies match
  $result = mysqli_query($conn, "SELECT user_username FROM user WHERE user_id = '$id'");
  $data = mysqli_fetch_assoc($result);

  if ($key === hash('gost-crypto', $data['user_username'])) {
    // set session
    $_SESSION['displayName'] = $data['user_username'];
    $_SESSION['logged'] = true;
  }

}

// check for session
if (!isset($_SESSION['logged'])) {
	$displayName = ucwords("log in to use available features");
} else {
	$displayName = "Welcome, " . ucwords($_SESSION['displayName']);
}


// generate random number for otp
$gotp = rand(1000, 10000);
$_SESSION['gotp'] = $gotp;

// send mail script
if (isset($_POST['sent'])) {
$username = $_POST['username'];

// check for username
$q = mysqli_query($conn, "SELECT user_username FROM user WHERE user_username = '$username'");
if (mysqli_num_rows($q) !== 1) {
	echo "<script>alert('Account Not Found!'); window.location = 'resetpass.php'</script>";
	return false;
}


// check if otp is 4 digit
if (strlen(strval($gotp)) !== 4) {
	echo "<h1>Sorry</h1>Something Went Wrong Please Try Again Later<br><hr><strong>Error : 0001</strong>";
	return false;
}

	$user_email = $_POST['user_email'];


	$query = mysqli_query($conn, "SELECT * FROM user WHERE user_email = '$user_email'");
	$data = mysqli_fetch_assoc($query);

	// check if email connected to account
	if (mysqli_num_rows($query) === 1) {
	$user_username = $data['user_username'];
	$user_telp = $data['user_telp'];
	$_SESSION['user_id'] = $data['user_id'];

$to_email = $user_email;
$subject = "Find Your Account";
$body = "Hi, {$user_email}. You've requested Reset Password for your account, If you did not request account finding Please DO NOT SHARE THE OTP CODE TO ANYONE and Please IGNORE this email. Thank You\n \n \nYour OTP Code :\n{$gotp} \n \n \n ~VnPage~";
$headers = "From: \VnPage";
		if (mail($to_email, $subject, $body, $headers)) {
			$success = true;
			$done = true;
		} else {
			$failed = true;
		}
		
	} else {
		$error = true;
	}



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
	</style>
	<title>Home ~ VnPage</title>
</head>
<body>

<!-- BODY -->

	<!-- navbar -->

	<nav class="navbar navbar-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href=""><img src="favico/navbarico.png"> VnPage</a>
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
          <a class="nav-link text-white" href="index.php">Home</a>
        </li>
    	<li class="nav-item">
          <a class="nav-link text-white" href="login.php">Login</a>
        </li>
    </ul>
  </div>
</div>
	<!-- /offcanvas -->

	<!-- /navbar -->


	<!-- body -->

	<br class="user-select-none">
	<section class="notiflist container-sm">
		<p class="h5 p-2 text-light bg-info rounded text-center"><a class="link-light text-decoration-none" href="findacc.php">Find Your Account</a> > <a class="link-light text-decoration-none" href="resetpass.php">Forgot Password</a></p>
	</section>


	<br class="user-select-none">
	<!-- if error -->
	<?php if (isset($error)) : ?>
	<div class="alert danger container-sm">
  	<span class="closebtn">&times;</span>  
  	<strong>Notice!</strong> <?= ucwords("we couldn't find the account with the associated email address") ?>
	</div>
	<?php endif; ?>

	<!-- Input section -->
	<?php if (!isset($done)) : ?>
	<div class="container-sm">
		<div class="row">
			<div class="col-12 d-flex justify-content-center">
				<label for="user_email" class="text-light fw-bold">Enter your username</label>
			</div>
			<form method="post">
			<div class="col-12 mt-2 mb-3 d-flex justify-content-center">
				<input id="user_username" type="text" name="username" class="form-control w-50" required>
			</div>
		</div>
		<div class="row">
			<div class="col-12 d-flex justify-content-center">
				<label for="user_email" class="text-light fw-bold">Enter your email to send OTP Code</label>
			</div>
			<div class="col-12 mt-2 d-flex justify-content-center">
				<input id="user_email" type="email" name="user_email" class="form-control w-75" required>
			</div>
			<div class="col-12 mt-3 d-flex justify-content-center">
				<button class="btn btn-outline-success" type="submit" name="sent">Send</button>
			</div>
			</form>
		</div>
	</div>
<?php endif; ?>
	<!-- /Input section -->

	<div class="container-sm text-center text-light">
		<?php if (isset($success)) : ?>
		<h6>OTP Code has been sent to <?= $user_email ?>, Please check your email inbox</h6>
		<hr>
		<script type="text/javascript">window.location = 'verify-otp.php'</script>
		<?php $_SESSION['acc-found'] =  true; ?>
		<?php $_SESSION['user_email'] = $data['user_email'] ?>
	<?php endif; ?>

	<?php if (isset($failed)) : ?>
		<h6>Account Support Email failed to sent, Please try again later</h6>
		<hr>
	<?php endif; ?>

	</div>
	<!-- /body -->

	<!-- Footer -->

	<footer class="text-secondary mt-auto fixed-bottom fs-6 p-1 user-select-none">
		VnPage Copyright	&copy; 2022
	</footer>

	<!-- /Footer -->

<!-- /BODY -->

<!-- Javascript with Popper -->
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
<!-- /Javascript with Popper -->
<script src="ajax/jquery.min.js"></script>
<script src="script.js"></script>
<script type="text/javascript">
</script>
</body>
</html>