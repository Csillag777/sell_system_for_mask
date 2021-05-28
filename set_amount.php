<?php
session_start();

$dbservername='localhost';
$dbname='test';
$dbusername='test01';
$dbpassword='1234';

try{
  if (!isset($_POST['newamount']))
  {
    header("Location: index.php");
    exit();
  }
  if (empty($_POST['newamount'])){
    echo "<script>alert('Please input a amount.'); location.href = 'shop_owner.php';</script>";
    exit();}
  elseif ((int)$_POST['newamount']<0){
    echo "<script>alert('Please input a correct amount(>=0).'); location.href = 'shop_owner.php';</script>";
    exit();}
  else{
  $newamount=$_POST['newamount'];
  
  $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
  # set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
  $stmt=$conn->prepare("update shop_list set amount=:newamount where SID=:SID");
  $stmt->execute(array('newamount' => $newamount, 'SID' => $_SESSION['owner_shop_SID']));

  $_SESSION['owner_mask_amount']=$newamount;  
  
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