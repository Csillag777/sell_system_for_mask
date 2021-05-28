<?php
  session_start();
  # remove all session variables
  session_unset(); 
  # destroy the session 
  session_destroy();
  $_SESSION['Authenticated']=false;
  
  $dbservername='localhost';
  $dbname='test';
  $dbusername='test01';
  $dbpassword='1234';
  
  $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
?>
<link href="home.css" rel="stylesheet">
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!DOCTYPE html>
<html>
<body style="margin-left: 20px;">
    <h1 id = "head1" style="margin-left: -20px;">The Sell System for Mask</h1>
<h1 style="background: white;">Login</h1>
<form action="login.php" method="post">
  <div class="l">
<span style="font-size:20px;">
  User Name:</span>
</div>
  <div id="shopinput">
  <input type="text" name="uname"></div>
<br>
<div class="l">
<span style="font-size:20px;">
  Password:</span>
  <div id="shopinput">
  <input type="password" name="pwd"><br></div></div>
  <input type="submit"  class="btn btn-info btn-lg" value="Login">

<h1 style="background: white;">Create Account</h1>
</form>
<form action="register.php" method="post">
<span style="font-size:20px;">
  User Name:</span>
  <div id="shopinput">
  <input type="text" name="uname"><br></div>
  <div class="l">
  <span style="font-size:20px;">
  Password:</span>
  <div id="shopinput">
  <input type="password" name="pwd"><br></div>
</div>
  <span style="font-size:20px;">
  Password check:</span>
  <div id="shopinput">
  <input type="password" name="pwd_c"><br></div>
  <span style="font-size:20px;">
  Phone number:</span>
  <div id="shopinput">
  <input type="text" name="p_num"><br></div>
  <input type="submit"  class="btn btn-info btn-lg" value="Create Account">
</form>

</body>
</html> 