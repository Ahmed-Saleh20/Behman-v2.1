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
				<h1><strong>Behman</strong></h1>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-6" style="left:0.5%;">
			<img src="includes/images/1.jpg" class="img-rounded" title="Behman" width="100%" height="565px" >
			<div id="centered1" class="centered"><h3 style="color:#eee;"><span class="glyphicon glyphicon-search"></span><strong>Follow Your psychologists.</strong></h3></div>
			<div id="centered2" class="centered"><h3 style="color:#eee;"><span class="glyphicon glyphicon-user"></span><strong>Hear what people are talking about.</strong></h3></div>
			<div id="centered3" class="centered"><h3 style="color:#eee;"><span class="glyphicon glyphicon-envelope"></span><strong>Join the conversation.</strong></h3></div>
		</div>

		<div class="col-sm-6" style="left: 8%;">

			<img src="includes/images/Behman.jpg" class="img-rounded" title="Coding Cafe" width="400px" height="100px" style="border:1px solid #eee">
			<h2><strong>You care about us</strong></h2><br><br>
			<h4><strong>Join To Behman Today.</strong></h4>
				
				<a href="signup.php" id="signup" class="btn btn-info btn-lg" class="button">SignUp</a>
				<a href="signin.php" id="login" class="btn btn-primary btn-lg" class="button">Login</a>

		</div>
	</div>
<?php
	Include 'includes/templates/footer.php';
?>
