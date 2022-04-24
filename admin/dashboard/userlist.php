<!-- login admin -->
<?php 
session_start();

// check for session login
if  (!isset($_SESSION['admlog'])) {
    header("Location: ../");
}

// query users account
require '../../Function-Lib/functions.php';
$rows = query("SELECT * FROM user");
$emptyrow = mysqli_query($conn, "SELECT COUNT(*) AS rowcount FROM user
");
$emptyres = mysqli_fetch_assoc($emptyrow);
// var_dump($emptyres);

// view profile's
if (isset($_GET['vp'])) {
    $user_id = $_GET['vp'];
    $vp = true;
    // query user acc
    $q = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'");
    $up = mysqli_fetch_assoc($q);
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

    <!-- when user got deleted -->
    <?php if (isset($_SESSION['delsucc'])): ?>
        <div class="alert success mt-2 container">
  <a id="clsbtn_alert" class="closebtn text-decoration-none">&times;</a>  
  <strong>Alert!</strong> Delete Successful
</div>
        <?php unset($_SESSION['delsucc']) ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['delfail'])): ?>
        <div class="alert mt-2 container">
  <a id="clsbtn_alert" class="closebtn text-decoration-none">&times;</a>  
  <strong>Alert!</strong> Delete Failed
</div>
        <?php unset($_SESSION['delfail']) ?>
        <?php endif; ?>
    <!-- when user got deleted end -->

    <!-- table -->
    <div class="container mt-4 border border-black shadow rounded">
        <table class="table table-striped table-hover mt-1 shadow rounded">
            <thead>
                <tr class="bg-light">
                    <th>No</th>
                    <th>Usernames</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <?php if($emptyres['rowcount'] === "0"): ?>
                <tr>
                    <td>There are no users</td>
                    <td>N/A Data</td>
                    <td>N/A Data</td>
                </tr>
                    <?php endif; ?>
            <?php $number = 1; ?>
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <td scope="row"><?= $number ?></td>
                    <td title="Click The Username To Extends Profile">
                        <a class="text-decoration-none text-black" href="userlist.php?vp=<?= $row['user_id'] ?>"><?= $row['user_username']; ?></a>
                    </td>
                    <td><a class="text-decoration-none" href="deluser.php?uid=<?= $row['user_id'] ?>">Delete</a></td>
                </tr>
            <?php $number++; ?>
            <?php endforeach; ?>

            </tbody>
        </table>
        
    </div>
    <!-- table end -->
                <hr class="shadow mt-5 mb-5 ms-2 me-2">
    <!-- view profile -->
    <?php if(isset($vp)): ?>
    <div class="container mt-4 border border-black shadow rounded">
        <table class="table table-striped table-hover mt-1 shadow rounded">
            <thead>

                <div class="container mt-1 mb-0">
                    <p class="fw-bold h5">
                        <?= ucwords($up['user_username']) ?>'s Profile
                    </p>
                </div>
            </thead>
            <tbody>
                <tr>
                    <li class="list-group-item">
                        Profile Picture : <a href="../../img/<?= $up['user_pfp'] ?>"><img width="100" height="100" src="../../img/<?= $up['user_pfp'] ?>" alt="User Profile Picture"></a>
                        <li class="list-group-item">
                            User ID : <?= $up['user_id'] ?>
                        </li>
                    </li>
                    <ul class="list-group">
                        <li class="list-group-item">
                            Username : <?= $up['user_username'] ?>
                        </li>
                        <li class="list-group-item">
                            Email : <?= $up['user_email'] ?>
                        </li>
                        <li class="list-group-item">
                            Encrypted Password : <input type="text" value="<?= $up['user_password'] ?>" disabled>
                        </li>
                        <li class="list-group-item">
                            Phone Number : <?= $up['user_telp'] ?>
                        </li>
                    </ul>
                </tr>
            </tbody>
        </table>    
    </div>
    <?php unset($vp); ?>
    <?php endif; ?>
    <!-- view profile end -->

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