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



	    if(isset($_POST['delete_playlist'])){
	    	$delete = $con->prepare("DELETE FROM playlist WHERE list_id =$playlist_id") ;
			$delete->execute(); 
			if($delete){
				echo "<script>alert('A Playlist has been deleted!')</script>";
				echo "<script>window.open('playlists.php?u_id=$user_id','_self')</script>";
			}
			else
			{
		      	  	echo "<script>alert('Un Expicted error while deleting playlist')</script>";
		        	echo "<script>window.open('upload_video.php?list_id=$playlist_id','_self')</script>";
		        	exit();

			}

	    }
	?>
	<?php } ?>

