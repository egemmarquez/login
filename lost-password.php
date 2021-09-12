<?php
session_start();
include('classes/login.php');

?>
<h2>Recover password</h2>
<form action="lost-password.php" method="GET">
  <input type="email" name="email"><br>
  <input type="submit" value="RESET PASSWORD">
</form>

<?php
if(!$_GET['email']) {}
else {
  $DB = new db();
  new lost_password($_GET['email'], $DB);
}
 ?>
</form>
