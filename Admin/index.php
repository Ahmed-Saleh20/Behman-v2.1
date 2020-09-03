<?php
	session_start();
	$pageTitle = 'Login';
	if(isset($_SESSION['adminName'])){
		header('Location:Dashboard.php');	
	}
    	include "initialize.php";
		/* Check if Admin Coming From HTTP Post Request */
     	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$username = $_POST['user']; 
			$password = $_POST['pass']; 
			// $hashedPass = sha1($password);

			$stmt = $con->prepare("
				SELECT user_id,user_name,user_pass FROM users WHERE user_name = ? AND user_pass = ? AND GroupID = 1 LIMIT 1
									");
			$stmt->execute(array($username, $password));
			$row = $stmt->fetch();	
			$count = $stmt->rowCount();

			/* If Count > 0 This Mean The Database Contain Record About This Username*/
	    	if ($count > 0) {
 				$_SESSION['adminName'] = $username; // Register Session Name
 				//adminName -> username that login 
 				$_SESSION['login_ID'] = $row['UserID']; // Register Session ID
 				//login_ID -> ID of user that login 
 				header('Location:Dashboard.php');
 				exit(); 
		    }else{
		    	echo "<script> alert('Username Or Password are Wrong!!')</script>";
		    }
		}
?>
	<h5>Username:Admin & pass:123</h5>
	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
	    <h4 class="text-center">Admin Login</h4>
	    <input class="form-control center" type="text" name="user" placeholder="Username" autocomplete="off" required="required"/>
	    <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" required="required"/>
	    <input class="btn btn-info btn-block" type="submit" value="Login"/>
	</form>
<?php
include $tpl.'footer.php'; 
?>