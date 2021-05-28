<?php
session_start();

$dbservername='localhost';
$dbname='test';
$dbusername='test01';
$dbpassword='1234';
$msg = "please login in !";
if(empty($_SESSION)){
    echo <<<EOT
    <!DOCTYPE html>
    <html>
      <body>
	    <script>
          alert("$msg");
		  window.location.replace("index.php");
        </script>
	  </body>
	</html>
EOT;
}
?>

<!DOCTYPE html>
<html>
  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link href="home.css" rel="stylesheet">

<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
<head>
</head>

<body>
    <h1 id = "head1">The Sell System for Mask</h1>
    <div class="nav">
        <div class="link1" >
          
        <a href="home2.php">
            <p>home</p></a>
        </div>
        <div class="link2" >
            <a href="shop_owner.php">
            <p>shop</p></a>
        </div>
        <div class="link3" style="background-color: white;">
            
            <p>My Order</p></a>
        </div>
        
        <div class="link4">
            <a href="shop_order1.php">
            <p>Shop Order</p></a>
        </div>
        <div class="link5">
            <a href="index.php">
            <p>logout</p></a>
        </div>
      </div>
        
<div class="intro">
<h3>My Order</h3>
<hr color="D1D2CD"/>

<!--form start -->
<form action="my_order1.php" method="get">
  
  <div class="link1">
      <p>Status</p>
  </div>
  <div id="shopinput">
      <select name="status">
          <option value="ALL">All</option>
          <option value="Not finished">Not finished</option>
          <option value="finished">finished</option>
          <option value="canceled">canceled</option>
      </select>
  </div>
  
<hr color="D1D2CD"/>
<button class="btn btn-primary btn-lg" type="submit">Search</button>

</form><br>
<!-- form finish -->
<table  class="table table-striped" id='t1' width='100%'>
  <tr id='column_name'>
    <th>OID</th>
    <th>Status</th>
    <th>Start</th>
    <th>End</th>
    <th>Shop</th>
    <th>Total Price</th>
    <th>Amount</th>
    <th>Price</th>
    <th>Action</th>
  </tr>

<?php
$conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
  # set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
if (isset($_GET['status'])&& (!isset($_GET['DeleteOID']))){
  
$stmt=$conn->prepare("select * from order1 where 1");
$stmt ->execute();
$row = $stmt->fetchAll();
$s1 = $_GET['status'];
  foreach ($row as $datainfo){
      if ($_SESSION["user_name"] == $datainfo['account']){
      if ($s1 == "ALL" || ($s1 == $datainfo['status'])){
      echo "<tr><td>". $datainfo['OID'] . " </td>";
      echo "<td>". $datainfo['status'] . " </td>";
      echo "<td>". $datainfo['start'] . " </td>";
      echo "<td>". $datainfo['end'] . " </td>";
      echo "<td>". $datainfo['shop'] . " </td>";
      echo "<td>$". $datainfo['total_price'] . " </td>";
      echo "<td>". $datainfo['amount'] . " </td>";
      echo "<td>$". $datainfo['price'] . " </td>";
      if ($datainfo['status']=="Not finished"){
      
      echo '<td><a href="?DeleteOID=' . $datainfo["OID"] . '
      &shopname=' . $datainfo["shop"] . '&deleteamount=' . $datainfo["amount"] . '" style="font-size:24px;background:white;border:none"><i style="color:red" class="fa fa-close"></i></a>
      </td>';
      }
      else{
        echo '<td></td>';
      }
      echo '</tr>';
      }
      }
    }
    echo "</table>";
  }
  if (isset($_GET['DeleteOID'])&& (!isset($_GET['status']))){
    $t3 = idate("H")+6;
if ($t3>24){
  $t3 = $t3-24;
  if ($t3<10){
    $t3 = "0".($t3);
  }
}
$t4 = date("Y/m/d $t3:i:s")."<br>User: ".$_SESSION['user_name'];
    $stmt2=$conn->prepare("update order1 set status=:status,end=:end where OID=:OID");
    $stmt2->execute(array('status' => "canceled",'end' => $t4,'OID' => $_GET['DeleteOID']));
    
    $stmt4=$conn->prepare("select amount from shop_list where name=:name");
    $stmt4->execute(array('name' => $_GET['shopname']));
$row1 = $stmt4->fetchAll();
foreach($row1 as $datainfo1){
  $a6 = $datainfo1['amount'];
  
}
    //echo $a6;
    //echo $_GET['deleteamount'];
    $stmt3=$conn->prepare("update shop_list set amount=:amount where name=:name");
    $stmt3->execute(array('amount' => $a6+$_GET['deleteamount'],'name' => $_GET['shopname']));
    echo <<<EOT
    <!DOCTYPE html>
    <html>
      <body>
	    <script>
          alert("cancel a deal");
		  window.location.replace("my_order1.php");
        </script>
	  </body>
	</html>
EOT;
  }
?>

</body>

</html>