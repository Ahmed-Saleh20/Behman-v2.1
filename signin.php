<!DOCTYPE html>
<html>
	<head>
		<title> Login Page </title>
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
					<center><h1><strong>Behman</strong></h1></center>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="main-content">
			        <div class="header">
			        	<h3 style="text-align: center;"><strong>Login to Behman</strong></h3><hr>
			        </div>
			        <div class="l-part">
			          	<form  action="signin.php" method="post">
			          		<input type="email" placeholder="Email" name="email" class="form-control input-md" required /><br>
			          		<div class="overlap-text">
				            	<input type="password" placeholder="Password" name="pass" class="form-control input-md" required /><br>
				            	<a style="text-decoration:none;color:#187FAB;"data-toggle="tooltip" title="Reset Password"  href="forgot_password.php">Forgot?</a>
			       			</div>
			       			<a style="text-decoration:none;float:right;color:#187FAB;"data-toggle="tooltip" title="Create Account!" href="signup.php">Don't have an account?</a><br><br>
			            	<center><button id="signin" class="btn btn-info btn-lg" name="login">Login</button></center>
			          </form>
			        </div>
		      	</div>
			</div>
		</div>	
<?php 
	session_start();
	$pageTitle = 'Login';
	if(isset($_SESSION['user_email'])){
		header('Location:home.php'); 		
	}
	include "initialize.php";
	if(isset($_POST['login'])){
		$email = htmlentities($_POST['email']);
		$pass = htmlentities($_POST['pass']);
		$hashedPass = sha1($pass);
		$select_user = $con->prepare("SELECT * FROM users WHERE user_email= ? AND user_pass= ? AND status='verified' LIMIT 1");
		$select_user ->execute(array($email, $pass));
		$row = $select_user ->fetch();	
		$count = $select_user->rowCount();
		if ($count > 0) {
			$_SESSION['user_email'] = $email; 
			$_SESSION['login_ID'] = $row['user_id']; 
			header('Location:home.php');
			exit(); 
		}
	}
?>		
<?php
	include 'includes/templates/footer.php';
?>
