<?php
session_start();

$dbservername='localhost';
$dbname='test';
$dbusername='test01';
$dbpassword='1234';

try{
  if (!isset($_POST['newprice']))
  {
    header("Location: index.php");
    exit();
  }
  if (empty($_POST['newprice'])){
    echo "<script>alert('Please input a price.'); location.href = 'shop_owner.php';</script>";
    exit();}
  elseif ((int)$_POST['newprice']<0){
    echo "<script>alert('Please input a correct price(>=0).'); location.href = 'shop_owner.php';</script>";
    exit();}
  else{
  $newprice=$_POST['newprice'];
  
  $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
  # set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
  $stmt=$conn->prepare("update shop_list set price=:newprice where SID=:SID");
  $stmt->execute(array('newprice' => $newprice, 'SID' => $_SESSION['owner_shop_SID']));

  $_SESSION['owner_mask_price']=$newprice;  
  
  echo "<script>alert('Set successfully.'); location.href = 'shop_owner.php';</script>";}
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