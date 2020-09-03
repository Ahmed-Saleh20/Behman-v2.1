<?php

	session_start();
	$pageTitle = "Welcome" ;
	if(isset($_SESSION['user_email'])){
		header('Location:home.php'); 		
	}
	include "initialize.php";
?>

	<div class="row">
		<div class="col-sm-12">
			<div class="well">
				<h1><strong>Welcome To Behman</strong></h1>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-6">
		 <img src="includes/images/1.jpg" class="index2-img" title="Behman" width="100%" height="515px" >
		</div>
		<div class="col-sm-6">
		<img src="includes/images/logo.jpg" title="Coding Cafe" width="95%" height="250px">
		<!-- <h2 style="text-align: cen">WE CARE ABOUT YOU</h2><br> -->
		<h4><strong>Join To Behman Today</strong></h4>
			<a href="signup.php" id="signup" class="btn btn-info btn-lg" class="button">SignUp</a>
			<a href="signin.php" id="login" class="btn btn-primary btn-lg" class="button">Login</a>
			<a href="docsignup.php" id="docsignup" class="btn btn-info btn-lg" class="button">Join as doctors</a>
		</div>
	</div>
<?php
	Include 'includes/templates/footer.php';
?>
