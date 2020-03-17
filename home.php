<?php
   /*
    *   
    * This File Include Home Page Which Include Post and Display .
    *
    */
session_start();
$pageTitle = "Home" ;
$noNavbar = ''; 
include("initialize.php");


if(!isset($_SESSION['user_email'])){
	header("location:index.php");
}else{ 

?>
<div class="container">
	<div class="row">
		<div id="insert_post" class="col-sm-12">
			<center>
		  	<form action="post.php?do=insert" method="post" id="f" enctype='multipart/form-data'>
				<input type="hidden" name="userid" value="<?php echo $user_id?>"/>
				<textarea class="form-control" id="content" rows="4" name="content" placeholder="What's in your Mind ?"></textarea><br/>
				<button type="sbumit" id="btn-post" class="btn btn-success">Post</button>
			</form>
			</center>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<center><h2><strong>News Feed</strong></h2><br></center>
			<?php get_posts();?>
		</div>
	</div>
</div>

<?php } ?>

<?php
	include 'includes/templates/footer.php';
?>


<!-- <span class='badge badge-secondary'> $count_msg</span> -->