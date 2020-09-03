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
		         <form  action="docsignup.php" method="post" enctype="multipart/form-data" >
		            <div class="input-group">
					    <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
					    <input type="text" class="form-control" placeholder="First Name" name="first_name" >
					</div><br>
					<div class="input-group">
					    <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
					    <input type="text" class="form-control" placeholder="Last Name" name="last_name" >
					</div><br>
		            <div class="input-group">
					    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					    <input id="password" type="password" class="form-control" name="u_pass" placeholder="Password" >
					</div><br>
		            <div class="input-group">
					    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					    <input id="email" type="text" class="form-control" name="u_email" placeholder="Email" >
					</div><br>
                     <div class="input-group">
					    <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
					    <input type="tel" class="form-control" placeholder="Phone number" name="pnum" >
					</div><br>
                     <div class="input-group">
					    <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
					    <input type="text" class="form-control" placeholder="Your Address" name="addrs" >
					</div><br>
					<div class="input-group">
					    <span class="input-group-addon"><i class="	glyphicon glyphicon-chevron-down"></i></span>
			            <select class="form-control" name="u_country" >
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
						<select class="form-control input-md" name="u_gender" >
							<option disabled="disabled">Select a Gender</option>
							<option>Male</option>
							<option>Female</option>
							<option>Others</option>
						</select>
					</div><br>
					<div class="input-group">
					    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
						<input type="date" name="u_birthday" class="form-control input-md"  >
					</div><br>
					
					<div class="input-group">
					    <span class="input-group-addon"><i class="glyphicon glyphicon-paperclip"></i></span>
						<input type="file" name="cv" class="form-control input-md" >
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

		// Upload Variables

		$fileName = $_FILES['cv']['name'];
		$fileSize = $_FILES['cv']['size'];
		$fileTmp  = $_FILES['cv']['tmp_name'];
		$fileType = $_FILES['cv']['type'];

		// 	List Of Allowed File Typed To Upload

		$fileAllowedExtension = array("jpeg","jpg","png","pdf","docx","ppt");

		// Get Avatar Extension

		$fileExtension = strtolower( end( explode('.',$fileName) ) );

		if(empty($fileName)){

			echo "<script>alert('CV Is Required TO Join')</script>";

		}
		if($fileSize > 11194304 ){

			echo "<script>alert('Files Can\'t Be Larger Than 10MG')</script>";

		}
		if( !empty( $fileName ) && !in_array( $fileExtension , $fileAllowedExtension ) ){

			echo "<script>alert('Files Extension Is Not Allowed')</script>";
		}

		$file = rand(0,1000) . '_' . $fileName;
		move_uploaded_file($fileTmp, "includes\doc_attachments\CVs\\" . $file );

		// Get Variables From The Form		
		$first_name = htmlentities($_POST['first_name']);
		$last_name = htmlentities($_POST['last_name']);
		$pass = htmlentities($_POST['u_pass']);
		$email = htmlentities($_POST['u_email']);
		$country = htmlentities($_POST['u_country']);
		$gender = htmlentities($_POST['u_gender']);
		$birthday = htmlentities($_POST['u_birthday']);
        $phone = htmlentities($_POST['pnum']);
        $address = htmlentities($_POST['addrs']);
		$newgid = sprintf('%05d', rand(0, 999999));
		$username = strtolower($first_name . "_" . $last_name . "_" . $newgid);
		$posts = "no";

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
			echo "<script>window.open('docsignup.php','_self')</script>";
			exit();
		}

		$stmt = $con->prepare("INSERT into 
									users (f_name,l_name,phone,user_name,describe_user,user_pass,user_email,user_country,
									user_gender,user_birthday,user_image,user_cover,user_reg_date,posts,
									recovery_account,GroupID,CV,address,approved)
									values 
                                    ('$first_name','$last_name','$phone','$username','Hello!! This is my default status','$pass','$email','$country','$gender','$birthday','default.png','default_cover.jpg',NOW(),'$posts','ifyouaregootatsomethingdontdoitforfree45566677888','2','$file','$address','0')");
		$stmt ->execute();

		if($stmt){
			echo "<script>alert('Congratulations doctor $first_name, your account will be reviewed. Thanks for joining us  .')</script>";
			echo "<script>window.open('home.php','_self')</script>";
		}else {
			echo "<script>alert('Registration failed, try again!')</script>";
			echo "<script>window.open('docsignup.php','_self')</script>";
		}
	}
?>	
<?php
	include 'includes/templates/footer.php';
?>