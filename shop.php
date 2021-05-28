<?php
session_start();

$dbservername='localhost';
$dbname='test';
$dbusername='test01';
$dbpassword='1234';
?>

<!DOCTYPE html>
<html>
<head>
</head>
<link href="home.css" rel="stylesheet">
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">

</div>
<body>
    <h1 id = "head1">The Sell System for Mask</h1>
    <div id="b1">
    <div class="nav">
        <div class="link1">
            <a href="home.php">
            <p>home</p></a>
        </div>
        <div class="link2" style="background-color: white;">
            <p>shop</p></a>
        </div>
        
        <div class="link3">
            <a href="my_order.php">
            <p>My Order</p></a>
        </div>
        
        <div class="link4">
            <a href="shop_order.php">
            <p>Shop Order</p></a>
        </div>
        <div class="link5">
            <a href="index.php">
            <p>logout</p></a>
        </div>
<div class="intro" style="background-color: white;">
<h3>Register shop</h3>
<p>* Since you do not have any shop, you can register one to sell masks ~</p>
<hr color="D1D2CD"/>
<h3>Shop List</h3>
<hr color="D1D2CD"/>
<div class="link1">
    <p>Shop</p>
</div>
<form action="shop_register.php" method="post">
<div id="shopinput">
    <input value="" name="sname" id="my1">
</div>
<hr color="D1D2CD"/>
<div class="link1">
    <p>City</p>
</div>
<div id="shopinput">
    <select name="city">
        <option value="Taipei">Taipei</option>
        <option value="Hsinchu">Hsinchu</option>
        <option value="Tainan">Tainan</option>
    </select>
</div>
<hr color="D1D2CD"/>
<div class="link1">
    <p>Masks Price</p>
</div>
<div id="shopinput">
    <input id="down" name="mask_price" value="">
    
</div>
<hr color="D1D2CD"/>
<div class="link1">
    <p> Masks Ammount</p>
</div>
<div id="shopinput">
    <input id="amount" name="amount" value="">
</div>
<hr color="D1D2CD"/>

<button class="btn btn-primary btn-lg" type="submit">Register</button>
</form>
</div>
</body> 
</html>