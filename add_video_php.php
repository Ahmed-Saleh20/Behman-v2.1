 

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

?>
<?php } ?>



	<?php   
    		if(isset($_POST['upload_video'])){

    		$views = 0;	
    	    $video_desc = htmlentities($_POST['video_desc']);
    		$video_title = htmlentities($_POST['video_title']);
	        $video = $_FILES['video']['name'];
	        $video_tmp = $_FILES['video']['tmp_name'];

	        $random_number = rand(1,500);
			$FileType = strtolower(pathinfo($video,PATHINFO_EXTENSION));
			
	        //check if tittle is empty
	      	if($video_title==''){
	        	echo "<script>alert('Please enter title for your video!')</script>";
	        	echo "<script>window.open('upload_video.php?list_id=$playlist_id','_self')</script>";
	        	exit();
	      	}
	      	else{

			      	 if ($FileType =='wemb' || $FileType =='mpg' || $FileType =='mp2' || $FileType =='mpeg' || $FileType =='mpv' || $FileType =='ogg' || $FileType =='mp4' || $FileType =='m4p' || $FileType =='m4v' || $FileType =='avi' || $FileType =='wmv' || $FileType =='mov' || $FileType =='qt' || $FileType =='flv' || $FileType =='swf' || $FileType =='avchd')
			      	  {
						//get screenshot from uploaded video
						        $ffmpeg = "C:\\ffmpeg\\bin\\ffmpeg";
								// $videofile = $_FILES['video']['tmp_name'];
								$jpg = "png";
								$imagefile = "video_pic.$random_number.$jpg";
								$getfromsecond = 5;
								$cmd = "$ffmpeg -i $video_tmp -an -ss $getfromsecond  includes/doc_attachments/playlist/videos_pic/$imagefile";
								shell_exec($cmd);
								$video_pic = "$imagefile";
				        

				        // claculate the length of uploaded video

				        $file='$video';
						$dur = shell_exec("ffmpeg -i ".$video_tmp." 2>&1");
						if(preg_match("/: Invalid /", $dur)){
						  return false;
						}
						preg_match("/Duration: (.{2}):(.{2}):(.{2})/", $dur, $duration);
						if(!isset($duration[1])){
						  return false;
						}
						$hours = $duration[1];
						$minutes = $duration[2];
						$seconds = $duration[3];
						          	
			          	   move_uploaded_file($video_tmp,"includes/doc_attachments/playlist/videos/$video.$random_number");

			          	   
			          	$insert = $con->prepare("INSERT into video(video_title,video_desc,video,playlist_id,user_id,video_pic,views,video_duration_hours,video_duration_minutes,video_duration_seconds)values('$video_title','$video_desc','$video.$random_number','$playlist_id','$userown_id','$video_pic','$views','$hours','$minutes','$seconds')");
					  	$insert ->execute();                
			         	if($insert){

						    $update_playlist = $con->prepare("UPDATE playlist SET list_videos='$videos' WHERE list_id='$playlist_id' ");
			  	            $update_playlist ->execute();
			  	            if ($update_playlist) {
			  	            	
			          	        echo "<script>window.open('upload_video.php?list_id=$playlist_id','_self')</script>";
			  	            }
			  	            else
			  	            {
			  	            	echo "<script>alert('counter column in playlist table  not updated but vide uploaded successfully')</script>";
			          	       echo "<script>window.open('upload_video.php?list_id=$playlist_id','_self')</script>";
			  	            }
			          	    
			          	}
			          	else
			          	{
			          	 echo "<script>alert('error while upload video!')</script>";
			          	 echo "<script>window.open('upload_video.php?list_id=$playlist_id','_self')</script>";
			          	}
			          }



			          
			          else
			          {
			      	  	echo "<script>alert('Please Select file with video format')</script>";
			        	echo "<script>window.open('add_video.php?list_id=$playlist_id','_self')</script>";
			        	exit();

	        }}
	    }
	?>
	<?php
	include 'includes/templates/footer.php';
?>
		        