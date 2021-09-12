<?php
session_start();
include('classes/login.php');
 ?>
<html>
<head><title>Sign in</title></head>
<body>
<h2>SIGN IN </h2>
<form action="sign-in.php?action=login" method="post" >
User:<br>
<input type="user" name="username"><br><br>
Pass<br>
<input type="password" name="pass" ><br><br>
<input type="submit" value="SIGN IN">
</form>
<br><br>
<a href="sign-up.php">SIGN UP</a>  / <a href="lost-password.php">Lost password?</a>
<?php if($_GET[action] == 'login')
{
  //We verify the user/pass is not blank
if ($_POST['username'] == '' or $_POST['pass'] == '') {
    exit('username / pass cant be blank');
  }
$DB = new db();
$login = new login($_POST['username'], $_POST['pass'], $DB);
$login->process();

} ?>
