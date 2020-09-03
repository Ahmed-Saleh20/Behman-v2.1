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
<?php include("includes/templates/slidbar.php"); ?>
<div class="row">
	<div class="col-sm-12">
		<center><h2>Find New People</h2></center><br><br>
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-5">
				<form class="search_form" action="">
		         <div class="form-group">
		          <input type="text" class="form-control search-field" name="search_user" placeholder="Search to Friend">
		         </div>
		         <button class="btn btn-info" type="submit" name="search_user_btn"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
		      	</form>
			<?php
				global $con;
				if(isset($_GET['search_user_btn'])){
				$search_query = htmlentities($_GET['search_user']);

				$get_user = 
				$con->prepare("SELECT * from users where f_name like '%$search_query%' OR l_name like '%$search_query%' OR user_name like '%$search_query%'");

				}else{
				$get_user = $con->prepare("SELECT * from users where GroupID != 1 ");
				}

				$get_user ->execute();
				$rows = $get_user ->fetchAll();	

				foreach ($rows as $key => $row_user){
					$user_id 	= $row_user['user_id'];
					$f_name 	= $row_user['f_name'];
					$l_name 	= $row_user['l_name'];
					$username 	= $row_user['user_name'];
					$user_image = $row_user['user_image'];
					$user_type 	= $row_user['GroupID'];
					
			?>
<!-- //now displaying all at once -->
			<div class='row' id='find_people'>
			  <div class='col-sm-4'>
			   <a href='user_profile.php?u_id=$user_id'>
			   <img 
			     class='img-circle search-img' src='includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.png'; } ?>' width='150px' 
			     height='140px' 
			     title='$username' 
			     />
			   </a>
			</div>
		<?php				
			if($user_type == 2 ){
	    	echo "<a href='doc_profile.php?u_id=$user_id'><h2 class='user-search'>$f_name $l_name</h2></a>";
	    	}else{
            echo "<a href='user_profile.php?u_id=$user_id'><h2 class='user-search' >$f_name $l_name</h2></a>";	    	}
		?>	
			</div>
<?php } ?>

			</div>
			<div class="col-sm-3">
	<?php
		$select_best = $con->prepare("SELECT user_image,user_name,nComments+nRating AS Total from users Where GroupID = 2 GROUP BY Total DESC LIMIT 5");
		$select_best ->execute();
		$bests = $select_best ->fetchAll();

	?>				
				<div class="bestPanel information">
					<div class="panel panel-info">
						<div class="panel-heading"><span>Best Doctor Of The Week</span></div>
						<img src="includes/images/Best.jpeg" class="panel-img-top" alt="...">
						<div class="panel-body">
							<ul class="list-unstyled">
								<?php foreach ($bests as $key => $best) { 
									$user_image = $best['user_image'];
								?>	
								<li class="best-li">
									<img src="includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.png'; } ?>" class="bestDoc-img" alt="...">
									<span><?php echo "<b>Dr</b>.".$best['user_name']?></span>
								</li>	
								<?php }?>										
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><br><br>



<?php } ?>
<?php
	include 'includes/templates/footer.php';
?>