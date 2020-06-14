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

    $stmt = $con->prepare("SELECT * FROM playlist WHERE list_id = $playlist_id ");
	$stmt->execute();
	$row = $stmt->fetch();
	$count = $stmt->rowCount();
	if($count > 0 ){
		$videos  = $row['list_videos'];
		$videos = $videos - 1;
	}
?>

<?php 
    	
    		if(isset($_POST['update_playlist'])){
    			
    		$playlist_title = htmlentities($_POST['playlist_title']);
	        $playlist_image = $_FILES['playlist_image']['name'];
	        $image_tmp = $_FILES['playlist_image']['tmp_name'];
	        $random_number = rand(1,500);
	        $videos = 0;
	        $privacy = 1;

			$FileType = strtolower(pathinfo($playlist_image,PATHINFO_EXTENSION));

	      	if($playlist_title==''){
	        	echo "<script>alert('Please enter title for your playlist!')</script>";
	        	echo "<script>window.open('playlists.php?u_id=$user_id','_self')</script>";
	        	exit();
	      	}else{

			      	 if ($FileType =='png' || $FileType =='jpg' || $FileType =='jpeg' || $FileType =='tif' || $FileType =='')
			      	  {
			          	if ($playlist_image != '') {
			          	   move_uploaded_file($image_tmp,"includes/doc_attachments/playlist/playlists_image/$playlist_image.$random_number");
			          	   $update = $con->prepare("UPDATE playlist SET list_name='$playlist_title',list_pic='$playlist_image.$random_number' WHERE list_id='$playlist_id'");
			          	}
			          	else
			          	{
			          		$update = $con->prepare("UPDATE playlist SET list_name='$playlist_title' WHERE list_id='$playlist_id'");
			          	}
					  	
					  	$update ->execute();                
			         	if($update){
			          	 echo "<script>alert('playlist updated!')</script>";
			          	echo "<script>window.open('playlists.php?u_id=$user_id','_self')</script>";
			          	}
			          }
			          else
			          {

			      	  	echo "<script>alert('Please Select file with just png,jpg,jpeg or tif format')</script>";
			        	echo "<script>window.open('upload_video.php?list_id=$playlist_id','_self')</script>";
			        	exit();
			          }
	        }
	    }


    	if(isset($_POST['update_video'])){

    	    $video_desc = htmlentities($_POST['video_desc']);
    		$video_title = htmlentities($_POST['video_title']);

	        //check if tittle is empty
	      	if($video_title==''){
	        	echo "<script>alert('Please enter title for your video!')</script>";
	        	echo "<script>window.open('upload_video.php?list_id=$playlist_id','_self')</script>";
	        	exit();
	      	}
	      	else{
	      		    // no discription
			      	if ($video_desc == '')
			      	{	   
				        $update = $con->prepare("UPDATE video SET video_title='$video_title',video_desc='' WHERE video_id='$video_id'");
			        }
			        // ther is discription
			        else
			        {
			        	$update = $con->prepare("UPDATE video SET video_title='$video_title',video_desc='$video_desc' WHERE video_id='$video_id'");
			        }

	        		$update ->execute();                
		         	if($update){
		          	 echo "<script>alert('video updated successfully')</script>";
		          	        echo "<script>window.open('display_video.php?v_id=$video_id','_self')</script>";
		          	}
		         	else
			        {
			          	 echo "<script>alert('error while udating the video!')</script>";
			          	 echo "<script>window.open('display_video.php?v_id=$video_id','_self')</script>";
			        }
			    }
	    }






	    if(isset($_POST['delete_video'])){
	    	$delete = $con->prepare("DELETE FROM video WHERE video_id = $video_id") ;
			$delete->execute(); 
			if($delete){

			    $update_playlist = $con->prepare("UPDATE playlist SET list_videos='$videos' WHERE list_id='$playlist_id' ");
			  	$update_playlist ->execute();

				echo "<script>alert('A video has been deleted!')</script>";
				echo "<script>window.open('upload_video.php?list_id=$playlist_id','_self')</script>";
			}
			else
			{
		      	  	echo "<script>alert('Un Expicted error while deleting Video')</script>";
		        	echo "<script>window.open('display_video.php?v_id=$video_id','_self')</script>";
		        	exit();

			}

	    }
	?>
	<?php } ?>

