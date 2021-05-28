<?php
session_start();
$_SESSION['Authenticated']=false;

$dbservername='localhost';
$dbname='test';
$dbusername='test01';
$dbpassword='1234';

try {
  if (!isset($_POST['uname']) || !isset($_POST['pwd']))
  {
    header("Location: index.php");
    exit();
  }
  if (empty($_POST['uname']) || empty($_POST['pwd']))
    throw new Exception('Please input user name and password.');
  
  /*if(preg_match('/^[a-zA-Z0-9]+$/', $_POST['pwd'])){
    throw new Exception('Invalid password format.');
  }*/
  
  if(!preg_match('/(?=.*[a-z])|(?=.*[A-Z])|(?=.*[0-9])/', $_POST['pwd'])){
    throw new Exception('Invalid password format.');
  }
  
  if(!preg_match('/(?=.*[0-9]){10}/', $_POST['p_num']) && !empty($_POST['p_num'])){
    throw new Exception('Invalid phone number format.');
  }

  if (empty($_POST['p_num']))
    throw new Exception('Please input phone number.');

  if (empty($_POST['pwd_c']) || $_POST['pwd']!=$_POST['pwd_c'])
    throw new Exception('Password check error.');
  
  

  $uname=$_POST['uname'];
  $pwd=$_POST['pwd'];
  $pwdc=$_POST['pwd_c'];
  $phone=$_POST['p_num'];
  $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
  # set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
  $stmt=$conn->prepare("select user_name from account where user_name=:username");
  $stmt->execute(array('username' => $uname));

  if ($stmt->rowCount()==0)
  { 
    $hashvalue=md5($pwd);
    $stmt=$conn->prepare("insert into account (user_name, password, phone) values (:username, :password, :phone)");
    $stmt->execute(array('username' => $uname, 'password' => $hashvalue, 'phone' => $phone));
	  
    echo <<<EOT
	  <!DOCTYPE html>
      <html>
        <body>
	      <script>
            alert("Create an account successfully. Please log in.");
            window.location.replace("index.php");
          </script>
        </body>
      </html>
EOT;
    exit();
  }
  else
    throw new Exception("Username existed.");
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
</body>
</html>
