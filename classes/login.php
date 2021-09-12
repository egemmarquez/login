<?php
//dbclass connection
class db {
 function __construct()
  {
    $this->host = 'localhost';
    $this->user = 'root';
    $this->password = '';
    $this->database = 'exam';
  }

  function connection() {
  //Mysqli connection query
    $this->mysqlink = new mysqli($this->host, $this->user, $this->password, $this->database);
    if (mysqli_connect_errno()) {
      printf("Connect Not working", mysqli_connect_error());
                   exit();
  }
return $this->mysqlink;
  }

}

//login class
class login {
private $DB;
function __construct($username, $password,DB $DB)
{
$this->DB = $DB;
//We receive user input. We sanitize email input and hash password to md5
$this->username = filter_var($username, FILTER_SANITIZE_MAGIC_QUOTES);
$this->password = filter_var(md5($password), FILTER_SANITIZE_MAGIC_QUOTES);
}

function process()
{
$connect = $this->DB->connection();
//Query to check if the user and pass matches.
$query = "SELECT user, pass, email from user where user = '$this->username' and pass = '$this->password'";
$result = $connect->query($query);
while($assoc = $result->fetch_assoc())
{

//if there's a coincidence, the user logs in and creates session
if(mysqli_num_rows($result) > 0)
{
session_start();
$_SESSION['active'] = TRUE;
$_SESSION['user'] = $assoc['user'];
$_SESSION['email'] = $assoc['email'];
//print_r($_SESSION);
header('location: user.php');
}

}
}
}

class user_header
{

function __construct($user, $active,$email)
{
  $this->user = $user;
  $this->active = $active;
  $this->email = $email;
  $this->CODE = $code;
if(!$active)
{
header('location: sign-in.php');
die();
}

}

public function welcome()
{
print "Welcome ".$this->user." ! your email is ".$this->email." <br><br> Today is ".date('Y/m/d')."";
}

}

class logout
{
public function __construct()
{
//destroy session
session_unset();
session_destroy();
//redirect
header('location: index.php');
}

}

class newuser
{
function __construct($user, $password, $email, DB $DB) {
if($password == '')
{
print "Password cant be blank";
die();
}
if($user == '')
{
  print "user cant be blank";
  die();
}
if($email == '')
{
  print "email cant be blank";
  die();
}
//if everything is ok, keep updating.
$this->DB = $DB;
$connect = $this->DB->connection();
$this->user = filter_var($user, FILTER_SANITIZE_MAGIC_QUOTES);
$this->password = filter_var(md5($password), FILTER_SANITIZE_MAGIC_QUOTES);
$this->email = filter_var($email, FILTER_SANITIZE_MAGIC_QUOTES);
//Update
$query = "INSERT into user (user, pass, email) values ('$this->user', '$this->password', '$this->email')";
print $query;
if(!$connect->query($query))
{
echo "There's an issue inserting your query";
}
else {
  echo "User created";



}

}
}


//Update password
class update
{
function __construct($password, $email, DB $DB) {
if($password == '')
{
print "Password cant be blank";
die();
}
$this->DB = $DB;
$connect = $this->DB->connection();
$this->password = filter_var(md5($password), FILTER_SANITIZE_MAGIC_QUOTES);
$this->email = $email;
//Update
$query = "UPDATE user SET pass = '$this->password' where email = '$this->email'";

if(!$connect->query($query))
{
echo "There's an issue updating your query";
}
else {
  echo "Password Udpated";
  header('location: index.php');
session_unset();
  session_destroy();

}

}
}

class lost_password
{
function __construct($email, DB $DB)
{
//DB Declaration
$this->DB = $DB;
$connect = $this->DB->connection();
//1st we verify the user is registered. if its not, the script ends.
$this->email = filter_var($email, FILTER_SANITIZE_MAGIC_QUOTES);
$query = "SELECT email from user where email = '$this->email' order by ID desc limit 0,1";
$result = $connect->query($query);
if($result->num_rows == 1)
{
$assoc = $result->fetch_assoc();
//we found the email address. We will create a temporary variables in the $_SESSION area. the CODE variable and the email address will be set.
// at the same time, i will create a link and display it. If the code on the URL matches the URL on session it will let users change the Password
$_SESSION['email'] = $assoc['email'];
$_SESSION['CODE'] = rand(100000,250000);
echo 'CODE link generated. please go to this link <a href="change-password.php?CODE='.$_SESSION['CODE'].'">GO LINK</a>';
}
else {
echo "Not a valid email";
}


}

}

?>
