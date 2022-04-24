<?php 
session_start();

if (!isset($_SESSION['admlog'])) {
    header("Location: ../");
}

require '../Function-Lib/functions.php';

// check for returned value on execution
if (hapus($_GET['uid']) > 0) {
    $_SESSION['delsucc'] = true;
    // echo 'succes';
    header("Location: userlist.php");
} else {
    $_SESSION['delfail'] = true;
    // echo 'fail';
    header("Location: userlist.php");
}