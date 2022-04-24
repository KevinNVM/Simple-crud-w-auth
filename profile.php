<?php 
// start session
session_start();


// check for session
if (!isset($_SESSION['logged'])) {
	$_SESSION['required'] = true;
	header("Location: login.php");
} else {
	$displayName = "Welcome, " . ucwords($_SESSION['displayName']);
}

require 'Function-Lib/functions.php';

// query user account

// check for user id
$user_id = $_COOKIE[hash('sha256', 'id')];


$query = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'");
$data = mysqli_fetch_assoc($query);


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
		#thumbnail {
			transition: transform 0.2s;
		}
		#thumbnail:hover {
			transform: scale(2);
		}
		.containerx {
		position: relative;
		}
		.overlay {
  position: absolute; 
  bottom: 0; 
  padding-left: 10px;
  padding-right: 16px;
  transition: .5s ease;
  opacity:0;
  text-align: center;
  background: rgba(0, 0, 0, 0.5);

		}

.containerx:hover .overlay {
  opacity: 1;
		}


	/* responsive */
		@media only screen and (max-width: 550px) {
  /* For phones: */
  	#thumbnail:hover {
  		transform: scale(2) translateX(-25px);
} }
	@media only screen and (max-width: 768px) {
  /* For tablets: */
  	#thumbnail:hover {
  		transform: scale(2) translateX(-25px);
} }
	</style>
	<title>Home ~ VnPage</title>
</head>
<body>

<!-- BODY -->

	<!-- navbar -->

	<nav class="navbar navbar-lg navbar-dark bg-dark">
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
          <a class="nav-link text-white" href="index.php">Home</a>
        </li>
    	<li class="nav-item">
          <a class="nav-link fw-bold text-white" href="profile.php">Profile</a>
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

	
	<!-- title -->

	<br class="user-select-none">
	<section class="notiflist container-sm">
		<p class="h3 text-light bg-primary rounded text-center">Profile</p>
	</section>

	<!-- /title -->

	<!-- content -->

	<section class="container">
		
		<table class="table text-light">
  <thead>
    <tr>
    	<th><a title="Edit Your Profile" class="text-light text-decoration-none" href="edit-profile.php?uid=<?= hash('sha256', $data['user_id']) ?>&section=all">Edit Profile</a></th>
    </tr>
  </thead>

  <!-- if succes -->
  <?php if (isset($_GET['success']) === true) { ?>
  <div class="alert success mt-2 container">
  <a id="clsbtn_alert" class="closebtn">&times;</a>  
  <strong>Info</strong> Changes Have Been Saved
</div>
<?php }; ?>

<!-- if succes -->
  <?php if (isset($_SESSION['edit-success']) === true) { ?>
  <div class="alert success mt-2 container">
  <a id="clsbtn_alert" class="closebtn">&times;</a>  
  <strong>Info</strong> Changes Have Been Saved
</div>
<?php unset($_SESSION['edit-success']) ?>
<?php }; ?>

  <tbody>
    <tr>
      <td class="pt-5 pb-5 float-start">Profile Picture</td>
      <td class="pt-3 pb-3 float-end">

      		<div class="containerx">
      		<img id="thumbnail" class="border border-light rounded shadow" src="img/<?= $data['user_pfp'] ?>" style="width: 100px; height: 100px;">
      	<a title="Click to Change" href="edit-profile.php?uid=<?= hash('sha256', $data['user_id']) ?>&section=profile-picture">
      		<div class="overlay text-info">Change <i class="bi bi-pencil-square"></i></div></a>
      		</div>

      	
      </td>
    </tr>
    <tr>
      <td class="pt-3 pb-3 float-start">Username</td>
      <td class="pt-3 pb-3 float-end"><?= $data['user_username'] ?></td>
    </tr>
    <tr>
      <td class="pt-3 pb-3 float-start">E-mail</td>
      <td class="pt-3 pb-3 float-end"><?= $data['user_email'] ?></td>
    </tr>
    <tr>
      <td class="pt-3 pb-3 float-start">Password</td>
      <td class="pt-3 pb-3 float-end"><a href="check-user-password.php?uid=<?= hash('sha256', $data['user_id']) ?>">Change Password</a></td>
    </tr>
    <tr>
      <td class="pt-3 pb-3 float-start">Phone Number</td>
      <td class="pt-3 pb-3 float-end">+<?= $data['user_telp'] ?></td>
    </tr>
  </tbody>
</table>

	</section>

	<!-- /content -->



<!-- /BODY -->

<!-- Javascript with Popper -->
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
<!-- /Javascript with Popper -->
<script src="ajax/jquery.min.js"></script>
<script src="script.js"></script>
<script type="text/javascript">
  
  // close pop up
  var cls = document.getElementById('clsbtn_alert')
  if (cls !== null) {
    
  }

</script>
</body>
</html>