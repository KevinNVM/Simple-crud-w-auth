<!-- login admin -->
<?php 
session_start();

// check login button
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // query from table admin
    include '../Function-Lib/functions.php';
    $query = mysqli_query($conn, "SELECT * FROM admin WHERE admin_username = '$username'");
    $data = mysqli_fetch_assoc($query);

    // check for username
    if (mysqli_num_rows($query) === 1) {
        // check for password
        if (password_verify($password, $data['admin_password'])) {
            
            // check if isowner value
            if ($data['isowner'] === "true") {
                $_SESSION['owner'] = true;
                $_SESSION['admlog'] = true;
                header("Location: dashboard/admin.php");
            } else {
                $_SESSION['admlog'] = true;
                $_SESSION['adminName'] = $data['admin_username'];
                header("Location: dashboard");
            }

        } else {
           $errorpass = true;
        }

    } else {
        $erroruser = true;
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
          <a class="nav-link link-light" href="../index.php">Home Page</a>
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
    <?php if(isset($erroruser)): ?>
    <div class="alert mt-2 container">
        <a id="clsbtn_alert" class="closebtn text-decoration-none">&times;</a>  
        <strong>Alert!</strong> Incorrect Username!
    </div>
    <?php unset($erroruser); ?>
    <?php endif; ?>

    <?php if(isset($errorpass)): ?>
    <div class="alert mt-2 container">
        <a id="clsbtn_alert" class="closebtn text-decoration-none">&times;</a>  
        <strong>Alert!</strong> Incorrect Password!
    </div>
    <?php unset($errorpass); ?>
    <?php endif; ?>
    <!-- error message end -->

    <!-- login section -->
    <div class="container mt-5 pt-3 d-flex justify-content-center">
    <div class="box border border-black w-50">    
    <form method="POST">
            <div class="row g-0 p-2">
                <div class="col-12">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control">
                </div>
            </div>
            <div class="row g-0 p-2">
                <div class="col-12">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control">
                </div>
            </div>
            <div class="row g-0 p-2">
                <div class="col">
                    <button class="btn btn-outline-danger" name="submit">Login</button>
                </div>
            </div>
        </form>
        </div>
    </div>
    <!-- login section end -->

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