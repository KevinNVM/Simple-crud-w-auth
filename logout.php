<?php 
session_start();

// destroy session and cookies
$_SESSION = [];
$_COOKIE = [];
// session_unset();
// session_destroy();


setcookie(hash('sha256', 'id'), '', time() - 3600);
setcookie('key', '', time() - 3600);
setcookie('cid', '', time() - 3600);
setcookie('cpass', '', time() - 3600);
setcookie('PHPSESSCKEY', '', time() - 3600);
setcookie('USERID', '', time() - 3600);

// redirect to login page
$_SESSION['islogout'] = true;
header("Location: index.php");


