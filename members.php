<!DOCTYPE html>
<?php
session_start();
$pageTitle = "Members" ;
$noNavbar = ''; 
include("initialize.php");

if(!isset($_SESSION['user_email'])){
	header("location:index.php");
}else{ 

?>

<div class="row">
	<div class="col-sm-12">
		<center><h2>Find New People</h2></center><br><br>
		<div class="row">
			<div class="col-sm-4">
			</div>
			<div class="col-sm-4">
			<form class="search_form" action="">
			  <input type="text" placeholder="Search Friends" name="search_user">
			  <button class="btn btn-info" type="submit" name="search_user_btn">Search</button>
			</form>
			</div>
			<div class="col-sm-4">
			</div>
		</div><br><br>
		<?php search_user();?>
	</div>
</div>

<?php } ?>
<?php
	include 'includes/templates/footer.php';
?>