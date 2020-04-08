
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

	$stmt = $con->prepare("SELECT * FROM users WHERE user_id = '$user_id' AND type = '1'");
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



    <div style="margin-left: 180px;margin-right: 25px;display: inline-flex;" class="card shadow mb-4">

        <div class="card-header py-3">
		<?php
		if ($user_id == $userown_id) {
		 ?>
<!-- action='upload_video.php?list_id=<?php echo $playlist_id ?>' -->
	    <form action='add_video.php?list_id=<?php echo $playlist_id ?>' method='POST' enctype='multipart/form-data'> 
		    <button  style="border:gray solid 0.5px;float:right;margin:7px;margin-right:15px;"  name='upload_video' class='btn '><img src="includes/doc_attachments/playlist/icons/plus.png" style="width: 15px;height: 15px;"> upload video</butto>
	    </form>

	<?php } ?>
        </div>
    <!-- start display playlists -->

    <?php 
    	if ($user_id != $userown_id) {
    		?><div  style="padding:1rem 1rem 1rem 3.5rem;min-width:1100px;min-height:560px; background-color: #F1F1F1;" class="card-body"><?php

    	} else {
    		?><div  style="padding:1rem 1rem 1rem 6.5rem;min-width: 1150px;min-height:520px; background-color: #F1F1F1;" class="card-body">
    	<?php } ?>


		<?php 

		    $stmt = $con->prepare("SELECT * FROM video WHERE  playlist_id = $playlist_id");
			$stmt->execute(array($user_id));
			$videoslist   = $stmt->fetchAll();
			$videos_count = $stmt->rowCount();
			if ($videos_count) {
			foreach ($videoslist as $key => $one_video){
				$video_id    = $one_video['video_id'];
				$video_pic   = $one_video['video_pic'];
				$video_title = $one_video['video_title'];
				$video_time  = $one_video['video_time'];
				$Video_views = $one_video['views'];
				$video_duration_hours	= $one_video['video_duration_hours'];
				$video_duration_minutes	= $one_video['video_duration_minutes'];
				$video_duration_seconds	= $one_video['video_duration_seconds'];

            ?>
             <a href="display_video.php?v_id=<?php echo $video_id?>" title="Play Now" style='text-decoration: none;'>
            <div style="display: inline-flex; padding-bottom:0.5rem;" class="card shadow ">
              <div style="padding: 0px; width: 246px;height: 270px;margin-top: 0px;"  class="card-body">
              	
                <div style="margin:12px; width: 226px;height: 137px; background-image: url('includes/doc_attachments/playlist/videos_pic/<?php echo $video_pic;?>');background-repeat: no-repeat;background-size: 100% 100%;"><div class="hov1" style="height: 100%;width: 100%;"> <div style="background-color:rgba(0,0,0,0.7);width: auto;height: 22px; float: right;margin-top: 112px; margin-right: 3.5px; color: white;font-size: bold; padding: 1px;padding-top: -8px;"><center style="margin-top: -6px;margin-right:2px;margin-left:2px;"><h5>
                	
                		<?php 
                			if ($video_duration_hours == 0) {
                					if ($video_duration_minutes <10) {
                							echo "0$video_duration_minutes:$video_duration_seconds";
                					}
                					else
                					{
                							echo "$video_duration_minutes:$video_duration_seconds";
                					}
                			}
                			else
                			{
                				
		                			if ($video_duration_minutes <10) {
		                					echo "$video_duration_hours:0$video_duration_minutes:$video_duration_seconds";
		               				}
		         					else
		           					{
	             							echo "$video_duration_hours:$video_duration_minutes:$video_duration_seconds";
	             					}
                								
                			}
                		?>

                </h5>
                	     </center>
                	 </div>

                	 		<div class="play-btn" style="width: 100%;height: 100%;">
							  
							    <svg style="width: 80px;margin-top: 25px;margin-left: 74px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26">
							      <polygon  class="play-btn__svg" points="9.33 6.69 9.33 19.39 19.3 13.04 9.33 6.69"/>
							    </svg> 
							  
							</div>
                	</div>
                </div>


		                <div style="margin-left: 19px;margin-right:10px; color: rgba(0,0,0,0.9);">
		                	  <h4><?php echo $video_title ?></h4>
		                </div>

		                <div style="color: #606060; margin-left: 20px; margin-top:-5px;">
		                	  <h6><?php
								$date = new DateTime($video_time);
								echo $Video_views.' Views <string style="font-size:16px;font-weight:bold;">.</string> '.$date->format('Y-m-d');
								?></h6>
		                </div>
                
              </div>
            </div>
        </a>
            
		       
<?php 
	}
	}

	else
		{
			echo "<center style='margin-left:360px;margin-top:250px;margin-right:435px;margin-bottom:200px;color:rgba(0,0,0,0.6)'><h3>this playlist is empty!<h3><center>";
		}?>

      </div>
    </div>
<?php } ?>
	<?php
	include 'includes/templates/footer.php';
?>
