<?php 

session_start();

unset($_SESSION['required']);

// Connect database
require 'Function-Lib/functions.php';

// check submit button
if (isset($_POST['submit'])) {
    
  // check for existing username
  $newUsername = $_POST['username'];
  $result = mysqli_query($conn, "SELECT * FROM user WHERE user_username = '$newUsername'");

  if (mysqli_num_rows($result) === 0 ) {
    
    if ($_POST['password'] == $_POST['password2']) {
      
    if ( tambah($_POST) > 0 ) {
      echo "<script>alert('Thank You For Signing Up! You can now Log into your account.'); window.location.href = 'login.php'</script>";
    } else {
      echo "<script>alert(Unable to confirm your request please try again later.'); window.location = 'index.php'</script>";
    }

  } else {
    $error = true;
  }

} else {
  echo "<script>alert('Username has already been taken!')</script>";
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
    a {
      color: white;
    }
    a:hover {
      color: darkgray;
    }
    input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
	</style>
	<title>Home ~ VnPage</title>
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
          <a class="nav-link text-white" href="index.php">Home</a>
        </li>
    	<li class="nav-item">
          <a class="nav-link text-white" href="login.php">Log in</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="resetpass.php">Reset Password</a>
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
  <span class="closebtn">&times;</span>  
  <strong>Alert</strong> Passwords Did Not Match!
</div>
<?php }; ?>



	<!-- lbody -->
  <h3 class="text-light text-center">Create Your Account For Free!</h3>

	<div class="container text-white mt-4 mb-5 d-flex justify-content-center">
		<form method="post" enctype="multipart/form-data">
      <input required type="hidden" name="pfp" value="default.jpg">
  <div class="input-group mb-3">
  <span class="input-group-text" id="inputGroup-sizing-default">Username</span>
  <input required type="text" class="form-control" aria-label="Sizing example input" name="username" aria-describedby="inputGroup-sizing-default">
</div>
<div class="input-group mb-3">
  <span class="input-group-text" id="inputGroup-sizing-default">Password</span>
  <input required type="password" class="form-control" aria-label="Sizing example input" name="password" aria-describedby="inputGroup-sizing-default" id="exampleInputPassword1">
</div>
<div class="input-group">
  <span class="input-group-text" id="inputGroup-sizing-default">Confirm Password</span>
  <input required type="password" name="password2" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" id="exampleInputPassword2">
</div>
<div class="mb-2">
  <input type="checkbox" id="switch" class="form-check-input" onclick="showPass()">
  <label class="user-select-none" for="switch">Show Passwords</label>
</div>
<div class="input-group mb-0">
  <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
  <input required type="email" name="email" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div>
<div id="emailHelp" class="form-text mb-2">We'll never share your email with anyone else.</div>
<div class="input-group mb-4">
  <span class="input-group-text" id="inputGroup-sizing-default">Phone Number</span>
  <input required type="number" name="phone" value="62" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div>
<div class="input-group">
  <input required type="hidden" name="pfp" value="default.jpg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div>
  <div class="text-center">
  <button type="submit" name="submit" class="btn btn-primary ps-5 pe-5">Sign Up!</button>
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
  var y = document.getElementById("exampleInputPassword2");
  if (x.type === "password") {
    x.type = "text";
    y.type = "text";
  } else {
    x.type = "password";
    y.type = "password";
  }
}
</script>
</body>
</html>