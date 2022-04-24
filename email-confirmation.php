<?php 
// start session
session_start();

// check if cookies exist
require 'Function-Lib/functions.php';
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
  $id = $_COOKIE['id'];
  $key = $_COOKIE['key'];

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


// send mail script

if (isset($_POST['sent'])) {
	$user_email = $_POST['user_email'];


	$query = mysqli_query($conn, "SELECT * FROM user WHERE user_email = '$user_email'");
	$data = mysqli_fetch_assoc($query);

	// check if email connected to account
	if (mysqli_num_rows($query) === 1) {
	$user_username = $data['user_username'];
	$user_telp = $data['user_telp'];


$to_email = $user_email;
$subject = "Find Your Account";
$body = "Hi, {$user_email} Your Password Has Been Changed, If  ~VnPage~";
$headers = "From: \VnPage Support";
		if (mail($to_email, $subject, $body, $headers)) {
			$success = true;
			$done = true;
		} else {
			$failed = true;
		}
		
	} else {
		$error = true;
	}




}