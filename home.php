<?php
session_start();

$dbservername='localhost';
$dbname='test';
$dbusername='test01';
$dbpassword='1234';
?>

<!DOCTYPE html>
<html>
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
        <div class="link1" style="background-color: white;">
            <p>home</p></a>
        </div>
        <div class="link2" >
            <a href="shop.php">
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
      </div>
        
<div class="intro">

<h3>Profile</h3>
<hr color= "D1D2CD"/>
<p>Account</p>
<span id="accname"><?php echo '<div class="s">'.$_SESSION["user_name"].'</div>; '?></span>
<hr color="D1D2CD"/>
<p>Phone</p>
<span id="phoname"><?php echo '<div class="s">'.$_SESSION['phone'].'</div>; '?></span>
<hr color="D1D2CD"/>
<h3>Shop List</h3>
<hr color="D1D2CD"/>

<!--form start -->
<form action="home.php" method="post">
  <div class="link1">
      <p>Shop</p>
  </div>
  <div id="shopinput"> 
      <input type="text" name="shop">
  </div>
  <hr color="D1D2CD"/>
  <div class="link1">
      <p>City</p>
  </div>
  <div id="shopinput">
      <select type="text" name="city">
          <option value="ALL">All</option>
          <option value="Taipei">Taipei</option>
          <option value="Hsinchu">Hsinchu</option>
          <option value="Tainan">Tainan</option>
      </select>
  </div>
  <hr color="D1D2CD"/>
  <div class="link1">
      <p>Price</p>
  </div>
  <div id="shopinput">
      <input id="down" type="text" name="down">
      <span id="~"> ~ </span>
      <input id="up" type="text" name="up">
  </div>
  <hr color="D1D2CD"/>
  <div class="link1">
      <p>Ammount</p>
  </div>
  <div id="shopinput">
      <select type="text" name="amount">
          <option value="All">All</option>
          <option value="(售完) 0">(售完) 0</option>
          <option value="(稀少) 1 ~ 99">(稀少) 1 ~ 99</option>
          <option value="(充足) 100+">(充足) 100+</option>
      </select>
  </div>
<hr color="D1D2CD"/>
<button class="btn btn-primary btn-lg" type="submit">Search</button>

<label class="switch">
    <input type="checkbox" name="switch_l">
    <span class="slider round"></span>
  </label>
  <span id="hint1">
<p style="padding-left:10px">only show the shop I work at</p></span>
</form>
<!-- form finish -->
<table class="table table-striped" id='t1' width='70%'>
  <tr id='column_name'>
    <th>Shop</th>
    <th>City</th>
    <th>Mask Price</th>
    <th>Mask Amount</th>
    
    <th></th>
  </tr>
<?php
 
 
  if ($_POST){
	try{
  if (!isset($_POST['shop']) || !isset($_POST['city']) || !isset($_POST['down']) || !isset($_POST['up']) || !isset($_POST['amount']))
  {
    header("Location: home.php");
    exit();
  }

  

  //set shop
  if (empty($_POST['shop'])){
	$shop="'%'";	
  }else{
	$shop="'%".$_POST['shop']."%'";
  }
  //set city
  if (empty($_POST['city']) || $_POST['city']=="ALL"){
	$city="'%'";
  }else{
	$city="'".$_POST['city']."'";
  }
  //set down
  if (empty($_POST['down'])){
	$down="0";
  }elseif ((int)$_POST['down']<0){
	echo "<script>alert('Please input correct price(>=0).'); location.href = 'home.php';</script>";
  }else{
	$down=$_POST['down'];
  }
  //set up
  if (empty($_POST['up'])){
	$up="2147483647";
  }elseif ((int)$_POST['up']<0){
	echo "<script>alert('Please input correct price(>=0).'); location.href = 'home.php';</script>";
  }else{
	$up=$_POST['up'];
  }
  //set amount
  if (empty($_POST['amount']) || $_POST['amount']=="ALL"){
	$amount="amount>=0";
  }elseif ($_POST['amount']=="(售完) 0"){
	$amount="amount=0";
  }elseif ($_POST['amount']=="(稀少) 1 ~ 99"){
	$amount="amount>=1 and amount<=99";
  }elseif ($_POST['amount']=="(充足) 100+"){
	$amount="amount>=100";
  }else{
	$amount="amount>=0";
  }
  
  $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
  # set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  

  if (!isset($_POST['switch_l'])){  
    $stmt="select * from shop_list where upper(name) like upper(".$shop.") and city like ".$city." and price>=".$down." and price<=".$up." and ".$amount;
    $stmt2=$conn->prepare($stmt);
	$stmt2->execute();
	//$query = $conn->query($stmt);
    $row = $stmt2->fetchAll();
  }else{
	$stmt="select distinct name, city, amount, price from shop_list inner join employee
	on shop_list.SID = employee.SID 
	where (account='".$_SESSION['user_name']."' or manager='".$_SESSION['user_name']."') and upper(name) like upper(".$shop.") and city like ".$city." and price>=".$down." and price<=".$up." and ".$amount;
    $stmt2=$conn->prepare($stmt);
	$stmt2->execute();
	//$query = $conn->query($stmt);
    $row = $stmt2->fetchAll();
  }
  
  //第一次輸出
  foreach ($row as $datainfo)
  {
      echo '<form action="home.php" method="get">
      <tr><td><input type="text"  value="'. $datainfo["name"] . ' " id="b6" name="shop_name"</td>';
      echo "<td>". $datainfo['city'] . " </td>";
      echo "<td>$". $datainfo['price'] . " </td>";
      echo "<td>". $datainfo['amount'] . " </td>";
      echo '<td><input value="" id="b5" name="buy_amount" id="my1">';
      echo '<button type="submit" onclick=\"return confirm("Buy?")\" class="btn btn-warning">buy</a></td></tr></form>';
  }
  echo "</table>";
}
catch(Exception $e)
{
  $msg=$e->getMessage();
  session_unset(); 
  session_destroy(); 
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
}
$conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
$t3 = idate("H")+6;
if ($t3>24){
  $t3 = $t3-24;
  if ($t3<10){
    $t3 = "0".($t3);
  }
}
$t4 = date("Y/m/d $t3:i:s")."<br>User: ".$_SESSION['user_name'];


if(isset($_GET['buy_amount'])){	
  $o = $_GET['buy_amount'];
  
  $stmt1=$conn->prepare("select * from shop_list where name =:name");
  
	$stmt1->execute(array('name' => $_GET['shop_name']));
  
  $row = $stmt1->fetchAll();
  foreach ($row as $datainfo){
    
    echo "<br>";
    
    $p3 = $datainfo['amount'];
      $p2 = $datainfo['price'];
    
  }
  echo $o;
  
  $o = floatval($o)*10000;
  $o = $o%10000;
  if(($_GET['buy_amount']>$p3)){
    echo <<<EOT
      <!DOCTYPE html>
      <html>
        <body>
        <script>
            alert("amount is not enough");
        window.location.replace("home.php");
          </script>
      </body>
    </html>
  EOT;
  
  exit();
  }
  if(!($o == 0)){
    echo <<<EOT
      <!DOCTYPE html>
      <html>
        <body>
        <script>
            alert("amount should be a postive integer");
        window.location.replace("home.php");
          </script>
      </body>
    </html>
  EOT;
  
  exit();
  }
  $t6 = $p2*$_GET['buy_amount'].' $'.$p2.'*'.$_GET['buy_amount'];
    //echo $p2;
  $stmt=$conn->prepare("insert into order1 (status, start, end, shop, total_price,amount,price, account) values (:status, :start, :end, :shop, :total_price,:amount,:price,:account)");
  $stmt->execute(array('status' => "Not finished", 'start' => $t4, 'end' => "-", 'shop' =>  $_GET['shop_name'], 'total_price' => $p2*$_GET['buy_amount'], 'amount' => $_GET['buy_amount'], 'price' => $p2, 'account' =>  $_SESSION['user_name']));
  $stmt3=$conn->prepare("update shop_list set amount=:amount where name =:name");
  $stmt3->execute(array('amount' => $p3-$_GET['buy_amount'], 'name' => $_GET['shop_name']));

  echo <<<EOT
  <!DOCTYPE html>
  <html>
    <body>
    <script>
        alert("successful deal");
    window.location.replace("home.php");
      </script>
  </body>
</html>
EOT;

  exit();
}

?>

</body>

</html>