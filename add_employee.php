<?php
session_start();

$dbservername='localhost';
$dbname='test';
$dbusername='test01';
$dbpassword='1234';

try{
  if (!isset($_POST['new_name']))
  {
    header("Location: index.php");
    exit();
  }
  if (empty($_POST['new_name']))
    echo "<script>alert('Please input a name.'); location.href = 'shop_owner.php';</script>";
  
  $newname=$_POST['new_name'];
  
  $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
  # set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
  $stmt=$conn->prepare("select * from account where user_name=:username");
  $stmt->execute(array('username' => $newname));
  
  $stmt2=$conn->prepare("select * from employee where account=:username and SID=:SID");
  $stmt2->execute(array('username' => $newname, 'SID' => $_SESSION['owner_shop_SID']));
  
  if ($stmt->rowCount()==0){
	  echo "<script>alert('No this user.'); location.href = 'shop_owner.php';</script>";
  }
  elseif ($stmt2->rowCount()==0)
  { 
    $row=$stmt->fetch();
    $stmt3=$conn->prepare("insert into employee (SID, account, phone) values (:SID, :account, :phone)");
    $stmt3->execute(array('SID' => $_SESSION['owner_shop_SID'], 'account' => $newname, 'phone' => $row['phone']));
	  
    echo <<<EOT
	  <!DOCTYPE html>
      <html>
        <body>
	      <script>
            alert("Add an employee successfully.");
            window.location.replace("shop_owner.php");
          </script>
        </body>
      </html>
EOT;
  exit();
  }
  else
  {
	echo "<script>alert('Employee existed.'); location.href = 'shop_owner.php';</script>";
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