
<?php
	session_start();
	$pageTitle = "files" ; 
	$noNavbar = ''; 
	include("initialize.php");
	if(!isset($_SESSION['user_email'])){
		header("location: index.php");
	}else{ 
?>

    <?php
    $video_id = isset($_GET['v_id']) && is_numeric($_GET['v_id']) ? intval($_GET['v_id']) : 0 ;

    $stmt = $con->prepare("SELECT * FROM video WHERE video_id = $video_id ");
	$stmt->execute();
	$row = $stmt->fetch();
	$count = $stmt->rowCount();
	if($count > 0 ){
		$current_video_title = $row['video_title'];
		$current_video_desc  = $row['video_desc'];
		$current_video       = $row['video'];
		$current_video_time  = $row['video_time'];
		$current_video_pic   = $row['video_pic'];
		$current_video_views       = $row['views'];
		$current_user_id     = $row['user_id'];
		$current_views       = $row['views'];
		$playlist_id         = $row['playlist_id'];
	}

	//update video views
    $new_views = $current_views +1;
	$update_views = $con->prepare("UPDATE video SET views='$new_views' WHERE video_id='$video_id'");
	$update_views->execute();

	$stmt = $con->prepare("SELECT * FROM users WHERE user_id = '$current_user_id ' AND GroupID = '2'");
	$stmt->execute(array($current_user_id ));
	$row = $stmt->fetch();
	$count = $stmt->rowCount();

	if($count > 0 ){
		$user_image = $row['user_image']; 
		$id         = $row['user_id'];
		$name       = $row['user_name'];
		$f_name     = $row['f_name'];
		$l_name     = $row['l_name'];

		/* Check IF User Is Owner User */
		$user = $_SESSION['user_email'];
		$get_user  = $con->prepare("SELECT * from users where user_email='$user'");
		$get_user  ->execute();
		$row = $get_user  ->fetch();	
		$userown_id = $row['user_id'];
		$user_name = $row['user_name'];
	}

	// Get playlists from database


?>


<?php 
  // gets the user IP Address
  $user_ip=$_SERVER['REMOTE_ADDR'];


?>

<link href="includes/doc_attachments/local_css.css" rel="stylesheet">


<?php include("includes/templates/slidbar.php"); ?>



    <div style=" width: 800px;height: 537px; margin-left: 320px;margin-right: 10px;display: inline-flex;" class="card  mb-4"> 


    <!-- start display playlists -->
			<div  style="display:inline-flex; background-color: #F1F1F1; padding-left: 0rem;" class="card-body">
				<div>
				<video style=" margin-top: 2px; margin-left:80px;margin-right:20px;" width="620" height="350" controls="">
					<source src="includes/doc_attachments/playlist/videos/<?php echo $current_video;?>" type="">
				</video><br>



			               <div style="width: 600px; margin-left: 80px; margin-top: 15px;">
			              		<?php 								 
			              		$date = new DateTime($current_video_time);
								    $current_video_time = $date->format('d-m-Y');

			              			echo "<h3 style='color:
			              			Balck;font-size:30px;'>$current_video_title</h3>

			              			<p style='color:#606060'>$current_video_views  Views <strong>.</strong> 
			              			     $current_video_time
			              			</p><br><br>
			              			<p style='font-size:15px;margin-top:-30px;'>$current_video_desc</p>
			              				";
			              		?>
			               </div>			        
			            </div>   

			      </div>
    </div>	
<div style="height: 150px; width: 140px; background-color: #CCC;margin-left: 80px;margin-top:170px;border-top-left-radius:8px;border-bottom-left-radius:8px; position: fixed;display: inline-flex;">

		<div style="margin-top: -180px;" class="profile">
			<a href='doc_profile.php?u_id=<?php echo $id;?>' title="view profile" style="text-decoration: none;"><img 
				src='includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.png'; } ?>' 
				            	class='img-circle'
				            	alt='Profile' 	 
				            	width='50px' 
				            	height='50px' 
			 /><?php echo "<h5 style='margin-left:-13px;font-weight:bold;color:black;'>$f_name $l_name</h5>"; ?></a>
		</div>
	<form action='playlists.php?u_id=<?php echo $id ?>' method='POST' enctype='multipart/form-data'>
		<center style="margin-top: 100px;">
		    <button style="background-color:#DDDDDD font-weight:bold;width: 120px;border-bottom-left-radius: 20px;border-top-left-radius: 20px;margin-left: 20px;" class='btn btn-info'>Playlists</button>
		</center>
	</form>
	</div>
<?php } ?>



	<?php
	include 'includes/templates/footer.php';
?>
