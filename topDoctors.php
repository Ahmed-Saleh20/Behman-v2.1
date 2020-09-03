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
		<center><h2>Best Doctors Of The Week</h2></center><br><br>
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-5">
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
			?>

			<?php
				$select_best = $con->prepare("SELECT *,nComments+nRating AS Total from users Where GroupID = 2 GROUP BY Total DESC LIMIT 5");
				$select_best ->execute();
				$bests = $select_best ->fetchAll();
	
				foreach ($bests as $key => $best){
					$user_id 	= $best['user_id'];
					$f_name 	= $best['f_name'];
					$l_name 	= $best['l_name'];
					$username 	= $best['user_name'];
					$user_image = $best['user_image'];
					$user_type 	= $best['GroupID'];
					
			?>
<!-- //now displaying all at once -->
			<div class='row' id='find_people'>
			  <div class='col-sm-4'>
			   <a href='user_profile.php?u_id=<?php echo $user_id ?>'>
			   <img 
			     class='img-circle search-img' src='includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.png'; } ?>' width='150px' 
			     height='140px'  
			     />
			   </a>
			</div>
		<?php				
			if($user_type == 2 ){
	    	echo "<a href='doc_profile.php?u_id=$user_id'><h2 class='user-search'>Dr. $f_name $l_name</h2></a>";
	    	}else{
            echo "<a href='user_profile.php?u_id=$user_id'><h2 class='user-search' >$f_name $l_name</h2></a>";}
		?>	
			</div>
<?php } ?>

			</div>
		</div><br><br>



<?php } ?>
<?php
	include 'includes/templates/footer.php';
?>