<?php
session_start();
include('classes/login.php');

if(!$_GET['CODE'])
{
new user_header($_SESSION['user'], $_SESSION['active'], $_SESSION['email']);
}
else {
if($_GET['CODE'] == $_SESSION['CODE'])
{
//we let user access to the Change Password
}
else {
  session_unset();
  session_destroy();
  header('location: index.php');
}
}
?>

<h2>Change Password for this account</h2>
<form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
New password <br>
<input type="password" name="password">
<input type="hidden" name="email"><br><br>
<input type="submit" value="UPDATE PASSWORD">
</form>
<br><br>
<?php if(isset($_POST))
{
  $DB = new db();
  new update($_POST['password'], $_SESSION['email'], $DB);
} ?>

<br><br>
<a href="user.php">User Area</a>
<a href="sign-out.php">Log out</a>
