<?php include('classes/login.php'); ?>
<html>
<head><title>Sign up</title></head>
<body>
  <h2>SIGN UP</h2>
  <form action="sign-up.php?register=done" method="post" >
  User:<br>
  <input type="text" name="username"><br><br>
  Pass<br>
  <input type="password" name="pass" ><br><br>
  Email<br>
  <input type="email" name="email"><br><br>
  <input type="submit" value="SIGN UP">
</form>
<?Php if($_GET['register'] == 'done')
{
  $DB = new db();
  new newuser($_POST['username'], $_POST['pass'], $_POST['email'], $DB);
}

 ?>

  <br><br>
  <a href="sign-in.php">SIGN IN</a>
</body>
