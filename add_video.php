

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
    $playlist_id = isset($_GET['list_id']) && is_numeric($_GET['list_id']) ? intval($_GET['list_id']) : 0 ;

    $stmt = $con->prepare("SELECT * FROM playlist WHERE list_id = $playlist_id ");
	$stmt->execute();
	$row = $stmt->fetch();
	$count = $stmt->rowCount();
	if($count > 0 ){
		$playlist_id = $row['list_id'];
		$user_id     = $row['user_id'];
		$videos  = $row['list_videos'];
		$videos = $videos + 1;
	}

	$stmt = $con->prepare("SELECT * FROM users WHERE user_id = '$user_id' AND GroupID = '2'");
	$stmt->execute(array($user_id));
	$row = $stmt->fetch();
	$count = $stmt->rowCount();

	if($count > 0 ){
		$id         = $row['user_id'];
		$name       = $row['user_name'];
		$f_name     = $row['f_name'];
		$l_name     = $row['l_name'];
		$user_image = $row['user_image'];

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
<link href="includes/doc_attachments/local_css.css" rel="stylesheet">

<div style="height: 280px; width: 140px; background-color: #CCC;margin-left: -2px;margin-top:130px;border-top-right-radius:8px;border-bottom-right-radius:8px; position: fixed;">

		<div style="margin-top: -180px;" class="profile">
			<a href='doc_profile.php?u_id=<?php echo $user_id;?>' title="view profile" style="text-decoration: none;"><img 
				src='includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.png'; } ?>' 
				            	class='img-circle'
				            	alt='Profile' 	 
				            	width='50px' 
				            	height='50px' 
			 /><?php echo "<h5 style='margin-left:-13px;font-weight:bold;color:black;'>$f_name</h5>"; ?></a>
		</div>
	<form action='playlists.php?u_id=<?php echo $user_id ?>' method='POST' enctype='multipart/form-data'>
		<center style="margin-top: 100px;">
		    <button style=" font-weight:bold;width: 120px;border-bottom-right-radius: 20px;border-top-right-radius: 20px;" class='btn btn-info'>Playlists</button>
		</center>
	</form>
	<form action='doc_folders.php?u_id=<?php echo $user_id ?>' method='POST' enctype='multipart/form-data'>
		<center style="margin-top: 10px;">
		    <button style="font-weight:bold;width: 120px;border-bottom-right-radius: 20px;border-top-right-radius: 20px;" class='btn btn-info'>Files</button>
		</center>
	</form>
	</div>


<center>
    <div style="width: 800px;margin-top: 40px;" class="card shadow mb-4">

        <div class="card-header py-3">

		    <form action='add_video_php.php?list_id=<?php echo $playlist_id ?>' method='POST' enctype='multipart/form-data'>
		    	
			<span style="">

	                <label><h4 style="margin-top:30px;">video tittle</h4><input maxlength="102" class="form-control" type="text" name="video_title" required="" style=" width: 300px;"></label><br>

					<label><h4 style="">your Video</h4></label>
					<div style="" class="form-group input-group">
					<input  type="file" style="width:300px;" class="form-control" name="video"></div>

<!-- 					<h4 style="">picture for the video (optional)</h4>

					<div style="" class="form-group input-group">
					<input  type="file" style="width:300px;" class="form-control" name="video_pic"></div> -->

					<label style=""><h4 style="margin-left:25px;" >video descrption (optional)</h4><textarea style="width: 300px;margin-left: 20px;" class="form-control" rows="4" name="video_desc" placeholder="discrip your video !"></textarea></label><br>

			        <button  style="margin-bottom: 60px;margin-top:20px;width:140px;border: solid 0.5px;" name='upload_video' class='btn '>Upload</button>
			</span>
		    </form>
        </div>
    </div>
</center>
<?php } ?>
	<?php
	include 'includes/templates/footer.php';
?>
		        