<?php
	session_start();
	if(isset($_SESSION['user_email'])){
	 header("location: home.php");
	}else{    
		include 'connectDB.php';		
?>
<!DOCTYPE html>
<html>
<head>
	<title>SignUp </title>
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
		          <h3 style="text-align: center;"><strong>Join To Behman</strong></h3><hr>
		        </div>
		        <div class="l-part">
		         <form  action="signup.php" method="post">
		            <div class="input-group">
					    <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
					    <input type="text" class="form-control" placeholder="First Name" name="first_name" required="required">
					</div><br>
					<div class="input-group">
					    <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
					    <input type="text" class="form-control" placeholder="Last Name" name="last_name" required="required">
					</div><br>
		            <div class="input-group">
					    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					    <input id="password" type="password" class="form-control" name="u_pass" placeholder="Password" required="required">
					</div><br>
		            <div class="input-group">
					    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					    <input id="email" type="text" class="form-control" name="u_email" placeholder="Email" required="required">
					</div><br>
					<div class="input-group">
					    <span class="input-group-addon"><i class="	glyphicon glyphicon-chevron-down"></i></span>
			            <select class="form-control" name="u_country" required="required">
							<option disabled>Select a Country</option>
							<option>Egypt</option>
							<option>United States of America</option>
							<option>India</option>
							<option>Japan</option>
							<option>UK</option>
							<option>France</option>
						</select>
					</div><br>
					<div class="input-group">
					    <span class="input-group-addon"><i class="glyphicon glyphicon-chevron-down"></i></span>
						<select class="form-control input-md" name="u_gender" required="required">
							<option disabled="disabled">Select a Gender</option>
							<option>Male</option>
							<option>Female</option>
							<option>Others</option>
						</select>
					</div><br>
					<div class="input-group">
					    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						<input type="date" name="u_birthday" class="form-control input-md" required="required" >
					</div><br>
					<a style="text-decoration:none;float: right; color:#187FAB;" data-toggle="tooltip" title="Signin" href="signin.php">Already have an account?</a><br><br>
		            <center><button id="signup" class="btn btn-info btn-lg" name="sign_up">Sign up</button></center>
		          </form>
		        </div>
	      </div>
		</div>
	</div>
<?php }?>
<?php
	if(isset($_POST['sign_up'])){
		global $con;
		$first_name = htmlentities($_POST['first_name']);
		$last_name = htmlentities($_POST['last_name']);
		$pass = htmlentities($_POST['u_pass']);
		$email = htmlentities($_POST['u_email']);
		$country = htmlentities($_POST['u_country']);
		$gender = htmlentities($_POST['u_gender']);
		$birthday = htmlentities($_POST['u_birthday']);
		$status = "verified";
		$posts = "no";
		$newgid = sprintf('%05d', rand(0, 999999));
		$username = strtolower($first_name . "_" . $last_name . "_" . $newgid);

		$check_username_query = $con->prepare("SELECT user_name from users where user_email='$email'");
		$check_username_query ->execute();
		$run_username = $check_username_query ->fetch();	
		
		if(strlen($pass)<8){
			echo "<script>alert('Password should be minimum 8 characters!')</script>";
			exit();
		}

		$check_email = $con->prepare("SELECT user_name from users where user_email='$email'");
		$check_email ->execute();
		$run_username = $check_email ->fetch();
		$check = $check_email->rowCount();

		if($check > 0){
			echo "<script>alert('Email already exist, please try another!')</script>";
			echo "<script>window.open('signup.php','_self')</script>";
			exit();
		}

		$stmt = $con->prepare("INSERT into 
									users 
									(f_name,l_name,user_name,describe_user,Relationship,user_pass,user_email,user_country,user_gender,user_birthday,user_image,user_cover,user_reg_date,status,posts,recovery_account,type,approved)
									values 
									('$first_name','$last_name','$username','Hello!! This is my default status','........','$pass','$email','$country','$gender','$birthday','default.png','default_cover.jpg',NOW(),'$status','$posts','ifyouaregootatsomethingdontdoitforfree45566677888','2','1')");
		$stmt ->execute();

		if($stmt){
			echo "<script>alert('Congratulations $first_name, your account has been created successfully.')</script>";
			echo "<script>window.open('home.php','_self')</script>";
            $_SESSION['user_email'] = $email;
            header('Location:home.php');
		}else {
			echo "<script>alert('Registration failed, try again!')</script>";
			echo "<script>window.open('signup.php','_self')</script>";
		}
	}
?>	
<?php
	include 'includes/templates/footer.php';
?>