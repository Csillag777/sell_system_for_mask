<?php
session_start();

$dbservername='localhost';
$dbname='test';
$dbusername='test01';
$dbpassword='1234';

try{
  if (!isset($_POST['sname']) || !isset($_POST['city']) || !isset($_POST['mask_price']) || !isset($_POST['amount']))
  {
    header("Location: index.php");
    exit();
  }
  if (empty($_POST['sname'])){
    echo "<script>alert('Please input shop name.'); location.href = 'shop.php';</script>";
	exit();
  }
  if (empty($_POST['mask_price']) || (int)$_POST['mask_price']<0){
    echo "<script>alert('Please input a correct price(Not null and >=0).'); location.href = 'shop.php';</script>";
	exit();
  }
  if (empty($_POST['amount']) || (int)$_POST['amount']<0){
    echo "<script>alert('Please input a correct amount(Not null and >=0).'); location.href = 'shop.php';</script>";
	exit();
  }
  
  $sname=$_POST['sname'];
  $city=$_POST['city'];
  $mprice=$_POST['mask_price'];
  $amount=$_POST['amount'];

  $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
  # set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
  $stmt=$conn->prepare("select name, city from shop_list where name=:sname and city=:city");
  $stmt->execute(array('sname' => $sname, 'city' => $city));
  
  if($stmt->rowCount()==0){
	  
	 $stmt=$conn->prepare("insert into shop_list (name, city, amount, price, manager) values (:name, :city, :amount, :price, :manager)");
     $stmt->execute(array('name' => $sname, 'city' => $city, 'amount' => $amount, 'price' => $mprice, 'manager' => $_SESSION['user_name']));
	  
	 $stmt2=$conn->prepare("select * from shop_list where name=:name");
     $stmt2->execute(array('name' => $sname));
	  
	 $row2 = $stmt2->fetch();
	 $_SESSION['owner_shop_SID']=$row2['SID'];
	 $_SESSION['owner_shop_name']=$row2['name'];
     $_SESSION['owner_shop_city']=$row2['city'];
	 $_SESSION['owner_mask_amount']=$row2['amount'];
	 $_SESSION['owner_mask_price']=$row2['price'];
	  
	 echo <<<EOT
	  <!DOCTYPE html>
      <html>
        <body>
	      <script>
            alert("Create a shop successfully.");
            window.location.replace("shop_owner.php");
          </script>
        </body>
      </html>
EOT;
    exit();
  }
  else{
    echo "<script>alert('Shop existed.'); location.href = 'shop.php';</script>";
	exit();
  }
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
?>