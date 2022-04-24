<?php 
// start session
session_start();

// check if cookies exist
require 'Function-Lib/functions.php';
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

// check for session
if (!isset($_SESSION['logged'])) {
	$displayName = ucwords("log in to use available features");
} else {
	$displayName = "Welcome, " . ucwords($_SESSION['displayName']);
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
  <link rel="stylesheet" href="css/style.css">
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
          <a class="nav-link fw-bold text-white" href="index.php">Home</a>
        </li>
    	<li class="nav-item">
          <a class="nav-link text-white" href="profile.php">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="settings.php">Settings</a>
        </li>
        <li class="nav-item">
          <?php if (isset($_SESSION['logged'])) : ?>
          <a id="account" title="Log Out" onclick="return confirm('Are you sure?')" class="nav-link fs-4 text-white logout" href="logout.php"><i class="bi bi-box-arrow-left"></i></a>
        <?php endif; ?>
        <?php if (!isset($_SESSION['logged'])) : ?>
        	<a id="account" title="Log In" class="nav-link fs-4 text-white login" href="login.php"><i class="bi bi-box-arrow-in-right"></i></a>
        <?php endif; ?>
        </li>
    </ul>
  </div>
</div>
	<!-- /offcanvas -->

	<!-- /navbar -->

	<!-- header -->

	<div class="container-sm mt-2">
		<div class="row g-1">
			<div class="col-8">
				<p class="form-control text-center link-dark fw-bold"><?= $displayName ?></p>
			</div>
			<div class="col-4">
				<div class="digital-clock form-control text-center link-primary fw-bold">00:00:00</div>
		</div>	
	</div>

	<!-- /header -->

  <?php if (isset($_SESSION['islogout'])) : ?>
  <div>
    <div class="alert success mt-2">
  <a id="clsbtn_notice" class="closebtn">&times;</a>  
  <strong>Success!</strong> Logout Successful
</div>
  </div>
  <?php unset($_SESSION['islogout']); ?>
<?php endif; ?>

	<!-- Notification -->

	<br class="user-select-none">
	<section class="notiflist container-sm">
		<p class="h3 text-light bg-primary rounded text-center">Notification</p>
	</section>

	<?php if (!isset($newNotif)) : ?>
	<div class="container-sm text-secondary fst-italic fw-light text-center pt-5">
		<h6>No Recent Notifications</h6>
		<hr class="mb-5">
	</div>
<?php endif; ?>

	<!-- /Notification -->

	<!-- Footer -->

	<!-- Remove the container if you want to extend the Footer to full width. -->
<div>

  <footer class="bg-secondary text-center text-white user-select-none">
  <!-- Grid container -->
  <div class="container p-2 pb-0">
    <!-- Section: Social media -->
    <section class="mb-2">
      <!-- Facebook -->
      <a title="Facebook" 
        class="btn btn-secondary btn-floating m-1"
        style="background-color: #3b5998;"
        href="https://www.facebook.com/madekevin.darmawan.5"
        role="button"
        target="_blank" 
        ><i class="bi bi-facebook"></i></a>

      <!-- Twitter -->
      <a title="Twitter" 
        class="btn btn-secondary btn-floating m-1 disabled"
        style="background-color: #55acee;"
        href=""
        role="button"
        target="_blank" 
        ><i class="bi bi-twitter"></i
      ></a>

      <!-- Google -->
      <a title="Google" 
        class="btn btn-secondary btn-floating m-1 disabled"
        style="background-color: #dd4b39;"
        href=""
        role="button"
        target="_blank" 
        ><i class="bi bi-google"></i></a>

      <!-- Instagram -->
      <a title="Instagram" 
        class="btn btn-secondary btn-floating m-1"
        style="background-color: #ac2bac;"
        href="https://www.instagram.com/mkevin_1"
        role="button"
        target="_blank" 
        ><i class="bi bi-instagram"></i></a>

      <!-- Linkedin -->
      <a title="Linkedin" 
        class="btn btn-secondary btn-floating m-1 disabled"
        style="background-color: #0082ca;"
        href=""
        role="button"
        target="_blank" 
        ><i class="bi bi-linkedin"></i></a>
      <!-- Github -->
      <a title="GitHub" 
        class="btn btn-secondary btn-floating m-1"
        style="background-color: #333333;"
        href="https://github.com/KevinNVM"
        role="button"
        target="_blank" 
        ><i class="bi bi-github"></i></a>
    </section>
    <!-- Section: Social media -->
  </div>
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center p-1" style="background-color: rgba(0, 0, 0, 0.2);">
    VnPage &copy; 2022 Copyright 
  </div>
  <!-- Copyright -->
</footer>
  
</div>
<!-- End of .container -->

	<!-- /Footer -->

<!-- /BODY -->

<!-- Javascript with Popper -->
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
<!-- /Javascript with Popper -->
<script src="ajax/jquery.min.js"></script>
<script src="script.js"></script>
<script type="text/javascript">
</script>
<noscript><?= "Please Turn On Your Javascript To Access This Website" ?></noscript>
</body>
</html>