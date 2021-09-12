<h2>User area</h2>
<?php
session_start();
include('classes/login.php');
$welcome = new user_header($_SESSION['user'], $_SESSION['active'], $_SESSION['email']);
$welcome->welcome();
 ?>

 <br><br>
 <a href="change-password.php">Change Password</a>
 <a href="sign-out.php">Log out</a>
