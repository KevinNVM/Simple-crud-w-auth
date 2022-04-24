<?php 
// start session
session_start();


// check for session
if (!isset($_SESSION['logged'])) {
	$_SESSION['required'] = true;
	header("Location: login.php");
}

require 'Function-Lib/functions.php';

// query user account
$user_id = $_COOKIE[hash('sha256', 'id')];
$query = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'");
$data = mysqli_fetch_assoc($query);


// get id from $get
$edit_id = $_GET['uid'];

// var_dump($_POST);

// update table
if (isset($_POST['sent'])) {
	// var_dump($_POST);

	// run function
	if ( ubahPFP($_POST) > 0 ) {
		
		// redirect user and display message
		$_SESSION['edit-success'] = true;
		header("Location: profile.php");
	} else {
		header("Location: index.php");
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
	<style type="text/css">
		body {
			background-color: rgb(24,24,24);
		}
		img {
  		height: auto;
		}
		.thumbnail {
			transition: transform 0.2s;
		}
		.thumbnail:hover {
			transform: scale(1.5);
		}
		@media only screen and (max-width: 550px) {
  /* For phones: */
  	.thumbnail:hover {
  		transform: scale(1.25) translateX(-25px);
} }
	@media only screen and (max-width: 768px) {
  /* For tablets: */
  	.thumbnail:hover {
  		transform: scale(1.25) translateX(-25px);
} }
	</style>
	<title>Edit Profiles ~ VnPage</title>
</head>
<body>

<?php 	
// check if id is match
if (hash('sha256', $user_id) !== $edit_id) {
		

	// kick from edit page with a message
	echo '
	<script>
	function test() {
		document.body.style.backgroundColor = "white";
		document.body.innerHTML = "<h1>Invalid User Account</h1>";
		document.body.innerHTML += "<hr>";
		document.body.innerHTML += "ERROR 404 NOT FOUND"
		setTimeout(function() {window.location.href = "profile.php"}, 2500)
	}
	setTimeout(test(), 5000)</script>';
	die();

} 

// set display
$display_i = 'none';
$display_p = 'none';
$display_pfp = '';

?>
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
    	<th><a title="Edit Your Profile" class="text-decoration-none link-primary fs-4 fw-bold" href="profile.php"><i class="bi bi-arrow-left"></i></a></th>
    </tr>
  </thead>
  <tbody>
  	<form method="post" enctype="multipart/form-data">
  		<div class="d-none">
  			<input type="hidden" name="user_id" value="<?= $data['user_id'] ?>">
  			<input type="hidden" name="user_pfp_old" value="<?= $data['user_pfp'] ?>">
  		</div>

  		<tr class="edit-pfp d-<?= $display_pfp ?>">
  			<td>Current Profile Picture</td>
  			<td>
  				<img class="border border-light rounded thumbnail shadow" src="img/<?= $data['user_pfp'] ?>" style="width: 100px; height: 100px;">
  			</td>
  		</tr>
  		<tr class="edit-pfp d-<?= $display_pfp ?>">
  			<td>Profile Picture</td>
  			<td>
  				<input type="file" class="form-control form-control-sm" name="user_pfp" onchange="loadFile(event)" id="inputGroupFile01">
  			</td>
  		</tr>
  		<tr class="edit-pfp d-<?= $display_pfp ?>">
  			<td>Preview</td>
				<td>
					<div class="container-sm">
						<img id="output" class="thumbnail rounded shadow border border-light" style="width: 100px; height: 100px;" alt="Please Choose a File">
					</div>
				</td>  			
  		</tr>
  		<tr>
  			<td style="border: none;">
  				<div class="form-text text-danger"><p class="text-danger">* <span class="text-info">Please Keep In Mind <br>Images That Are Not 500x500px Will Be Stretched</span></p></div>
  			</td>
  			<td style="border: none;">
  				<button type="submit" name="sent" class="btn btn-primary">Save Changes</button>
  			</td>
  		</tr>
  	</form>
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
	function unloadConfirm() {
	return	"unloaded";
}

// edit-profile.php => preview image
 var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
  //end
</script>
</body>
</html>