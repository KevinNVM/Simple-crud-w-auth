<?php 
// start session
session_start();

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


// send mail script

if (isset($_POST['sent'])) {
	$user_email = $_POST['user_email'];


	$query = mysqli_query($conn, "SELECT * FROM user WHERE user_email = '$user_email'");
	$data = mysqli_fetch_assoc($query);

	// check if email connected to account
	if (mysqli_num_rows($query) === 1) {
	$user_username = $data['user_username'];
	$user_telp = $data['user_telp'];


$to_email = $user_email;
$subject = "Find Your Account";
$body = "Hi, {$user_email} You've  requested account finding, If you did not request account finding Please IGNORE this email. Thank You\n \n \n Account Details\nUsername : {$user_username}\n Email : {$user_email}\n Phone Number : {$user_telp} \n \n \n ~VnPage~";
$headers = "From: \VnPage Support";
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
	<title>Find Account ~ VnPage</title>
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
        <li class="nav-item">
          <a class="nav-link text-white" href="resetpass.php">Reset Password</a>
        </li>
    </ul>
  </div>
</div>
	<!-- /offcanvas -->

	<!-- /navbar -->


	<!-- body -->

	<br class="user-select-none">
	<section class="notiflist container-sm">
		<p class="h3 text-light bg-info rounded text-center">Find Your Account</p>
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
				<label for="user_email" class="text-light fw-bold">Enter your email to find your account</label>
			</div>
			<form method="post">
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
		<h6>Account Support Email has been sent to <?= $user_email; ?>, Please check your email inbox</h6>
		<hr>
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