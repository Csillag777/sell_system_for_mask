<?php
session_start();

$_SESSION['Authenticated']=false;

$dbservername='localhost';
$dbname='test';
$dbusername='test01';
$dbpassword='1234';

try
{
  if (!isset($_POST['uname']) || !isset($_POST['pwd']))
  {
    header("Location: index.php");
    exit();
  }
  if (empty($_POST['uname']) || empty($_POST['pwd']))
    throw new Exception('Please input user name and password.');

  $uname=$_POST['uname'];
  $pwd=$_POST['pwd'];
  $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
  # set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
  $stmt=$conn->prepare("select user_name, password, phone from account where user_name=:username");
  $stmt->execute(array('username' => $uname));
  
  $stmt2=$conn->prepare("select * from shop_list where manager=:username2");
  $stmt2->execute(array('username2' => $uname));

  if ($stmt->rowCount()==1)
  {
    $row = $stmt->fetch();
    if ($row['password']==md5($pwd))
    {
      $_SESSION['Authenticated']=true;
      $_SESSION['user_name']=$row['user_name'];
      $_SESSION['phone']=$row['phone'];
	  if ($stmt2->rowCount()==0){
        header("Location: home.php");
	    exit();
	  }else{
		$row2 = $stmt2->fetch();
		$_SESSION['owner_shop_SID']=$row2['SID'];
		$_SESSION['owner_shop_name']=$row2['name'];
    $_SESSION['owner_shop_city']=$row2['city'];
		$_SESSION['owner_mask_amount']=$row2['amount'];
		$_SESSION['owner_mask_price']=$row2['price'];
		
		header("Location: home2.php");
	    exit();
	  }
	}
	else
	  throw new Exception('Wrong password.');
  }
  else
     throw new Exception('Login failed.');
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
