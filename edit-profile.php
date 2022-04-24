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

$user_id = $_COOKIE[hash('sha256', 'id')];
$query = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'");
$data = mysqli_fetch_assoc($query);


// get value from $_get
$edit_id = $_GET['uid'];
$edit_section = $_GET['section'];

// check if id is match
if (hash('sha256', $user_id) == $edit_id) {
	
	// redirect to each section
	if ($edit_section == 'profile-picture') {
		header("Location: edit-profile-picture.php?uid={$edit_id}");
	} 
	elseif ($edit_section == 'user-password') {
		header("Location: edit-profile-password.php?uid={$edit_id}");
	}
	else {
		header("Location: edit-profile-info.php?uid={$edit_id}");
	}
} else {
	echo "<script>alert('Invalid Account Identifier!'); window.location.href = 'profile.php'</script>";
}

