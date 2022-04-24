<!-- login admin -->
<?php

use Mpdf\Tag\P;

session_start();

// check for owner session
// if (!isset($_SESSION['owner'])) {
//     header("Location: index.php");
// }

// execute function
if (isset($_POST['submit'])) {
    include 'Function-Lib/functions.php';
    
    // check for returned value
    if ( register($_POST) > 0 ) {
        $success = true;
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
    <link rel="apple-touch-icon" sizes="180x180" href="../favico/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../favico/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../favico/favicon-16x16.png">
	<link rel="manifest" href="../favico/site.webmanifest">
    <link rel="stylesheet" href="css/style.css">
    <style>

    </style>
    <title>Login as Admin ~ VnPage</title>
</head>
<body>

    <!-- body -->

    <!-- navbar -->
	<nav class="navbar navbar-lg navbar-dark bg-danger shadow rounded-bottom">
  <div class="container">
    <a class="navbar-brand" href="index.php"><img src="../favico/navbarico.png"> VnPage</a>
    <button class="btn btn-danger" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"><i class="bi bi-list"></i></button>
    <div class="collapse navbar-collapse" id="navbarNav">
    </div>
  </div>
</nav>

	<!-- offcanvas -->
<div class="offcanvas offcanvas-end bg-danger" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title text-white" id="offcanvasWithBothOptionsLabel">Menu</h5>
    <button type="button" class="btn btn-danger text-light" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-x"></i></button>
  </div>
  <div class="offcanvas-body">
    <ul>
      <li class="nav-item">
          <a class="nav-link link-light" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link link-light" href="resetpassadmin.php">Forgot Password</a>
        </li>
    </ul>
  </div>
</div>

	<!-- /offcanvas -->
    <!-- navbar end -->

    <!-- error message -->
    <?php if(isset($error)): ?>
    <div class="alert mt-2">
        <a id="clsbtn_alert" class="closebtn text-decoration-none">&times;</a>  
        <strong>Alert!</strong> Incorrect Username!
    </div>
    <?php unset($error); ?>
    <?php endif; ?>

    <?php if(isset($success)): ?>
    <div class="alert success mt-2">
        <a id="clsbtn_alert" class="closebtn text-decoration-none">&times;</a>  
        <strong>Alert!</strong> Incorrect Password!
    </div>
    <?php unset($error); ?>
    <?php endif; ?>
    <!-- error message end -->

    <!-- register section -->
<div class="container mt-4 mb-5 d-flex justify-content-center">
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
<input required type="number" name="phone" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div>
<div class="input-group">
<input required type="hidden" name="pfp" value="default.jpg" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
</div>
<div class="text-center">
<button type="submit" name="submit" class="btn btn-danger ps-5 pe-5">Sign Up!</button>
</div>
</form>
</div>
    <!-- register section end -->

    <!-- body end -->


<!-- Javascript with Popper -->
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
<!-- /Javascript with Popper -->
</body>
</html>