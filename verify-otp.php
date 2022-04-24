<?php 
// start session
session_start();

// req db
include 'Function-Lib/functions.php';



$user_id = $_SESSION['user_id'];

// query user account
$sql = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'");
$data = mysqli_fetch_assoc($sql);

// debug
// var_dump($_POST, '<br class="user-select-none>', $_SESSION,'<br class="user-select-none>',);



// check for otp code
if (isset($_POST['submit'])) {
	$otp = $_POST['otpcode'];

	// check for match
	if ($otp == $_SESSION['gotp']) {
		$_SESSION['pass_checked'] = hash('sha256', $data['user_username']);
		// set login session
		$_SESSION['logged']= true;
		$_SESSION['displayName'] = $data['user_username'];
		$edit_id = hash('sha256', $data['user_id']);
		setcookie(hash('sha256', 'id'), $data['user_id'], time() + 60);
		setcookie("cid", hash('sha256', $edit_id), time() + 60);
		setcookie("cpass", hash('sha256', 'pass_checked'), time() + 60);
		$_SESSION['isreset'] = true;
		
		header("Location: edit-profile-password.php" . "?uid=" . hash('sha256', $data['user_id']));
	} else {
		echo "FAILED";
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

	<div class="container-sm text-center text-light">
		<?php if (isset($_SESSION['acc-found'])) : ?>
		<h6>OTP Code has been sent to <?= $_SESSION['user_email'] ?>, Please check your email inbox</h6>
		<hr>
		<div class="container-sm">
		<div class="row">
			<div class="col-12 d-flex justify-content-center">
				<label for="user_email" class="text-light fw-bold">Enter OTP Code</label>
			</div>
			<form method="post">
			<div class="col-12 mt-2 d-flex justify-content-center">
				<input id="otpcode" type="text" name="otpcode" class="form-control w-25 text-center p-0 fs-5" maxlength="4" autocomplete="off" autofocus required>
			</div>
			<div class="col-12 mt-3 d-flex justify-content-center">
				<button class="btn btn-outline-info" type="submit" name="submit">Submit</button>
			</div>
			</form>
		</div>
	</div>
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