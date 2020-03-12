<?php
	session_start();
	$pageTitle = "change Password" ; 
	if(!isset($_SESSION['user_email'])){
	 header("location: index.php");
	}else{   
  		include 'connectDB.php';	
		$user = $_SESSION['user_email'];
		$get_user = $con->prepare("SELECT * from users where user_email='$user'");
		$get_user ->execute();
		$row = $get_user ->fetch();			
		$user_id = $row['user_id'];
		$user_name = $row['user_name'];
?>
<!DOCTYPE html>
<html>
	<head>
		<title> Login Page </title>
		<meta charset="UTF-8"/>			
	    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="layout/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="layout/css/fontawse-min.css"/>
        <link rel="stylesheet" href="layout/css/Main.css"/>
        <script src="layout/js/jQuery v3.3.1 jquery.min.js"></script>
        <script src="layout/js/Bootstrap v3.3.7 bootstrap.min.js"></script>
	</head>
	<body>
	<div class="row">
		<div class="col-sm-12">
			<div class="well">
				<center><h1 style="color: white;"><strong>Behman</strong></h1></center>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="main-content">
		        <div class="header">
					<h3 style="text-align: center;"><strong>Change Your Password </strong></h3>
					<strong style="color:#187FAB; "><i><?php echo $user_name; ?></i></strong>
					<hr>
		        </div>
		        <div class="l-part">
		          <form  action="" method="post">
		          	<div class="input-group">
					    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					    <input id="password" type="password" class="form-control" name="pass" placeholder="New Password" required="required">
					</div><br>
					<div class="input-group">
					    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					    <input id="password" type="password" class="form-control" name="pass1" placeholder="Re-enter Password" required="required">
					</div><br>
		            <center><button id="signup" class="btn btn-info btn-lg" name="change">Change Password</button></center>
		          </form>
		        </div>
	      </div>
		</div>
	</div>
  	<?php
        if(isset($_POST['change'])){
			$pass = htmlentities($_POST['pass']);
			$pass1 = htmlentities($_POST['pass1']);
			if ($pass == $pass1) {
				if (strlen($pass) >= 6 && strlen($pass) <= 60) {
					
					$update = $con->prepare("UPDATE users set user_pass='$pass' where user_id='$user_id'");
					$update ->execute();
						echo "<script>alert('Your Password is changed a moment ago')</script>";
						echo "<script>window.open('home.php','_self')</script>";
				}else{
					echo "<script>alert('Your Password should be greater than 6 words')</script>";
					}
				}else{
					echo "<script>alert('Your Passwords did not match')</script>";
					echo "<script>window.open('change_password.php','_self')</script>";
				}
		}
    ?>
<?php } ?>

<?php
	include 'includes/templates/footer.php';
?>