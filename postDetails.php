<!DOCTYPE html>
<?php
	session_start();
	$pageTitle = "Post" ;
	$noNavbar='';
	include("initialize.php");
?>
<?php 
	if(!isset($_SESSION['user_email'])){
		header("location: index.php");
	}else{ 
?>

	<div class="row">
		<div class="col-sm-12">
			<center><h2>Comments</h2><br></center>
			<?php single_post(); ?>
		</div>
	</div>

<?php } ?>

<?php
	Include 'includes/templates/footer.php';
?>