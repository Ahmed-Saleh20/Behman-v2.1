<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password</title>
	<meta charset="utf-8">
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
		          <h3 style="text-align: center;"><strong>Forgot Password</strong></h3><hr>
		        </div>
		        <div class="l-part">
		          <form  action="" method="post">
		          	<div class="input-group">
								    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								    <input id="email" type="text" class="form-control" name="email" placeholder="Enter Your Email" required="required">
								</div><br>
								<hr>
								<pre class="text">Enter your BestFriend name down below</pre>
		          	 <div class="input-group">
								    <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
								    <input id="msg" type="text" class="form-control" placeholder="Someone" name="recovery_account" required="required">
								</div><br>
					<a style="text-decoration:none;float: right; color:#187FAB;" data-toggle="tooltip" title="Signin"  href="signin.php">Back to Signin?</a><br><br>
		            <center><button id="signup" class="btn btn-info btn-lg" name="submit">Submit</button></center>
		          </form>
		        </div>
	      </div>
		</div>
	</div>
<?php
	include 'includes/templates/footer.php';
?>
	
<?php
session_start();

include("connectDB.php");
	if(isset($_POST['submit'])){
		$email = htmlentities($_POST['email']);
		$recovery_account = htmlentities($_POST['recovery_account']);

		$select_user = $con->prepare("SELECT * from users where user_email='$email' AND recovery_account='$recovery_account'");
		$select_user ->execute();
		$user = $select_user ->fetch();	
		$count = $select_user->rowCount();

		if($count > 0){
			$_SESSION['user_email']=$email;
			echo "<script>window.open('change_password.php','_self')</script>";
		}
		else{
			echo "<script>alert('Your Email or your Bestfriend name is Incorrect')</script>";
			echo "<script>window.open('forgot_password.php','_self')</script>";
		}
	}
?>
