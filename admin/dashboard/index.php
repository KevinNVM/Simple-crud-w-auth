<!-- login admin -->
<?php 
session_start();

// check for session login
if  (!isset($_SESSION['admlog'])) {
    header("Location: ../");
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css'>
    <link rel="apple-touch-icon" sizes="180x180" href="../../favico/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../../favico/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../../favico/favicon-16x16.png">
	<link rel="manifest" href="../../favico/site.webmanifest">
    <link rel="stylesheet" href="../css/style.css">
    <style>

    </style>
    <title>Login as Admin ~ VnPage</title>
</head>
<body>

    <!-- body -->

    <!-- navbar -->
	<nav class="navbar navbar-lg navbar-dark bg-danger shadow rounded-bottom">
  <div class="container">
    <a class="navbar-brand" href=""><img src="../../favico/navbarico.png"> VnPage</a>
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
          <a class="nav-link link-light" href="userlist.php">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link link-light" href="resetpassadmin.php">Forgot Password</a>
        </li>
        <li class="nav-item">
          <?php if (isset($_SESSION['admlog'])) : ?>
          <a id="account" title="Log Out" onclick="return confirm('Are you sure?')" class="nav-link fs-4 text-white logout" href="logout.php"><i class="bi bi-box-arrow-left"></i></a>
        <?php endif; ?>
        <?php if (!isset($_SESSION['admlog'])) : ?>
        	<a id="account" title="Log In" class="nav-link fs-4 text-white login" href="../"><i class="bi bi-box-arrow-in-right"></i></a>
        <?php endif; ?>
        </li>
    </ul>
  </div>
</div>

	<!-- /offcanvas -->
    <!-- navbar end -->

    <!-- header -->
    <div class="container">
        <div class="row">
            <div class="col-12">
            <h4 class="ms-2 mt-3 fs-4 bg-light fw-bold border border-black p-1 text-center rounded">Welcome, <?= ucwords($_SESSION['adminName']) ?></h4>
            </div>
            <div class="col-12">
                <p class="fs-6 text-secondary fst-italic text-center">-No Recent Notification-</p>    
            <hr>
            </div>
        </div>
    </div>
    <!-- header end -->

    <!-- footer -->
    <footer class="container bg-light rounded">
        <p class="fs-6">VnPge &copy; Copyright 2022</p>
    </footer>
    <!-- footer end -->

    <!-- body end -->


<!-- Javascript with Popper -->
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
<!-- /Javascript with Popper -->
<script>
    var close = document.getElementsByClassName("closebtn");
var i;

for (i = 0; i < close.length; i++) {
  close[i].onclick = function(){
    var div = this.parentElement;
    div.style.opacity = "0";
    setTimeout(function(){ div.style.display = "none"; }, 600);
  }
}

</script>
</body>
</html>