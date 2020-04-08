
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
    
	    $user_id = isset($_GET['u_id']) && is_numeric($_GET['u_id']) ? intval($_GET['u_id']) : 0 ;

		$stmt = $con->prepare("SELECT * FROM users WHERE user_id = ? AND type = '1'");
		$stmt->execute(array($user_id));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();

		if($count > 0 ){
			$id = $row['user_id'];
			$name = $row['user_name'];
			$f_name = $row['f_name'];
			$l_name = $row['l_name'];
			$user_image = $row['user_image'];

			/* Check IF User Is Owner User */
			$user = $_SESSION['user_email'];
			$get_user  = $con->prepare("SELECT * from users where user_email='$user'");
			$get_user  ->execute();
			$row = $get_user  ->fetch();	
			$userown_id = $row['user_id'];
			$user_name = $row['user_name'];
		}

?>
<link href="sss.css" rel="stylesheet">

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
	<form action='playlists.php?u_id=<?php echo $user_id ?>' method='POST' enctype='multipart/form-data'>
		<center style="margin-top: 10px;">
		    <button style="font-weight:bold;width: 120px;border-bottom-right-radius: 20px;border-top-right-radius: 20px;" class='btn btn-info'>Files</button>
		</center>
	</form>
	</div>



    <div style="margin-left: 160px;margin-right: 25px;display: inline-flex;" class="card shadow mb-4">

        <div class="card-header py-3">
		<?php
		if ($user_id == $userown_id) {
		 ?>
	    <form action='add_video.php?list_id=<?php echo $playlist_id ?>' method='POST' enctype='multipart/form-data'> 
		    <button  style="border:gray solid 0.5px;float:right;margin:7px;margin-right:15px;"  name='upload_video' class='btn '><img src="includes/playlist/icons/plus.png" style="width: 15px;height: 15px;"> upload video</butto>
	    </form>

	<?php } ?>
        </div>
    <!-- start display playlists -->
<div  style="padding:1rem 1rem 1rem 4.5rem;min-width: 1185px;min-height:520px; background-color: #F1F1F1;" class="card-body">
		<?php 

		    $stmt = $con->prepare("SELECT * FROM filder WHERE  user_id = $user_id");
			$stmt->execute(array($user_id));
			$folders   = $stmt->fetchAll();
			$folders_count = $stmt->rowCount();
			if ($folders_count) {
			foreach ($folder as $key => $folder){

            ?>

            
		       
<?php 
	}
	}

	else
		{
			echo "<center style='margin-left:360px;margin-top:250px;margin-right:435px;margin-bottom:200px;color:rgba(0,0,0,0.6)'><h3>there are no Filders or files yet!<h3><center>";
		}?>

      </div>
    </div>
<?php } ?>
	<?php
	include 'includes/templates/footer.php';
?>
