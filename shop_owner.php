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
<link href="home.css" rel="stylesheet">
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script type="text/javascript" src="home.js"></script>

<head>
</head>


<body>
<h1 id = "head1">The Sell System for Mask</h1>
    <div id="b1">
    <div class="nav">
        <div class="link1">
            <a href="home2.php">
            <p>home</p></a>
        </div>
        <div class="link2" style="background-color: white;">
            <p>shop</p></a>
        </div>
        
        <div class="link3">
            <a href="my_order1.php">
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
<div class="intro">

<h3>My Shop</h3>
<hr color="D1D2CD"/>
<div class="link1">
    <p>Shop</p>
</div>
<div id="shopinput">
    <p><?php echo $_SESSION['owner_shop_name']; ?></p>
</div>
<hr color="D1D2CD"/>
<div class="link1">
    <p>City</p>
</div>
<div id="shopinput">
    <P><?php echo $_SESSION['owner_shop_city']; ?></P>
</div>
<hr color="D1D2CD"/>
<div class="link1">
    <p>Masks Price</p>
</div>

<form action="set_price.php" method="post">
<div id="shopinput">
    <input id="x1" name="newprice" type="number" value=<?php echo $_SESSION['owner_mask_price']; ?> >
    <button class="btn btn-success" type="submit">set</button>
</div>
</form>

<hr color="D1D2CD"/>
<div class="link1">
    <p> Masks Ammount</p>
</div>

<form action="set_amount.php" method="post">
<div id="shopinput">
    <input id="x2" name="newamount" type="number" value=<?php echo $_SESSION['owner_mask_amount']; ?> >
    <button class="btn btn-success" type="submit">set</button>
</div>
</form>

<!-- 清除文字 -->
<script type="text/javascript">
function resettext(id){
    //恢復文字
    if(id.value == "")
    {
    id.value = id.defaultValue;
    id.className ="t1";   
    }
}
function cleartext (id){
    //清除文字
    id.value ="";
    d.className ="";   
}
</script>

<hr color="D1D2CD"/>
<h3>Employee</h3>
<form action="add_employee.php" method="post">
<input value="type account" name="new_name" onfocus="cleartext(this)" onblur="resettext(this)">
<button class="btn btn-success" type="submit">Add</button>
</form>
<div id="space"></div>

<?php
	$SID = $_SESSION['owner_shop_SID'];
	
    // 連接資訊 
    $conn=new PDO("mysql:host=localhost;dbname=test", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt="select account, phone from employee where SID=" . $SID;
    
    // 運行 SQL
    $query    = $conn->query($stmt);
    $datalist = $query->fetchAll();

	if(isset($_GET['DeleteID']) AND !empty($_GET['DeleteID'])){	
		$stmt2=$conn->prepare("delete from employee where SID=:SID and account=:name");
		$stmt2->execute(array('SID' => $_SESSION['owner_shop_SID'], 'name' => $_GET['DeleteID']));
    
		echo "<script>alert('Delete " . $_GET['DeleteID'] . " successfully.'); location.href = 'shop_owner.php';</script>";
	}
 
    //第一次輸出
    echo "<table  id='t1' width='700px'>
    <tr id='column_name'>
      <th>Account</th>
      <th>Phone</th>
      
      <th></th>
    </tr>";
	
    foreach ($datalist as $datainfo)
    {	
        echo "<tr><td>". $datainfo['account'] . " </td>";
        echo "<td>". $datainfo['phone'] . " </td>";
		echo "<td><a href='?DeleteID=" . $datainfo['account'] . "' onclick=\"return confirm('Delete?')\" class=\"btn btn-warning\">delete</a></td></tr>";
    }
    echo "
	</table>";
?>

</html>