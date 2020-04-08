
<?php
	session_start();
	$pageTitle = "Playlists" ; 
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
		    <button style="background-color:#DDDDDD font-weight:bold;width: 120px;border-bottom-right-radius: 20px;border-top-right-radius: 20px;" class='btn btn-info'>Playlists</button>
		</center>
	</form>
	<form action='doc_folders.php?u_id=<?php echo $user_id ?>' method='POST' enctype='multipart/form-data'>
		<center style="margin-top: 10px;">
		    <button style="font-weight:bold;width: 120px;border-bottom-right-radius: 20px;border-top-right-radius: 20px;" class='btn btn-info'>Files</button>
		</center>
	</form>
	</div>


    <div style="margin-left: 160px;margin-right: 25px;display: inline-flex;min-width: 1185px;min-height:570px;" class="card shadow mb-4">

        <div style="padding-bottom: 0rem;" class="card-header py-3">
		<?php
		if ($user_id == $userown_id) {
		 ?>
		 	<form action='playlists.php?u_id=<?php echo $user_id ?>' method='POST' enctype='multipart/form-data'>
	    	
		        <span style="display: inline-flex;margin-top: 5px;margin-bottom:-20px;">

				<h4 style="width: 95px;margin-left:20px;" >Playlist title</h4><input maxlength="56" class="form-control" type="text" name="playlist_title" required="" style="width:250px;">
					<h4 style="margin-left: 80px;">Playlist Picture (optional)</h4>
						<div style="" class="form-group input-group">
							<input  type="file" style="margin-left: 5px;" class="form-control" name="playlist_image">
							 </div>
			            <button  style="border:gray solid 0.5px; margin-left: 110px;height: 35px;" name='add_playlist' class='btn '><img src="includes/doc_attachments/playlist/icons/plus.png" style="width: 15px;height: 15px;"> Add Playlist</butto>
		       </span>
	        </form>
	        
<?php }?>
        </div>

    <!-- start display playlists -->
<div  style=" background-color: #F1F1F1; padding-left: 4rem;" class="card-body">
		<?php 

			$stmt = $con->prepare("SELECT * FROM playlist WHERE user_id = $user_id AND privacy = '1'");
			$stmt->execute(array($user_id));
			$Playlistsy = $stmt->fetchAll();
			$playlist_count = $stmt->rowCount();
			if ($playlist_count) {
			foreach ($Playlistsy as $key => $list){
			$user_id     = $list['user_id'];
			$list_id     = $list['list_id'];
			$list_name   = $list['list_name'];
			$list_picture    = $list['list_pic'];
			$list_time   = $list['list_time'];
			$list_videos = $list['list_videos'];

            ?>
 
      	<a class="all" href='upload_video.php?list_id=<?php echo $list_id ?>' title="View all Videos" style="text-decoration:none; display: inline-flex;">
      	<div>
		        <div style="margin:5px; width: 246px;height: 137px; background-image: url('includes/doc_attachments/playlist/playlists_image/<?php echo $list_picture;?>');background-repeat: no-repeat;background-size: 100% 100%;" >
		        	
		        	<div style="color: #FFFFFF;float: right;width: 108px;height: 137px; background-color: rgba(0,0,0,0.6);">
		        		<center>
		        			
		        			<h4 style="margin-top: 33px; margin-bottom:-5px; "><?php echo $list_videos; ?></h4>
		        					<svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon" style="margin-top:0px; pointer-events: none; display: block; width: 50%; height: 50%; fill: #FFFFFF;">
							        <path d="M3.67 8.67h14V11h-14V8.67zm0-4.67h14v2.33h-14V4zm0 9.33H13v2.34H3.67v-2.34zm11.66 0v7l5.84-3.5-5.84-3.5z"></path>
							      </g></svg>
							       
		        		</center>
		        	</div>
		        </div>  
		        <!-- <div style="margin-top: 26px;margin-bottom: -10px;"><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h4></div> -->
		        <div style="color: black; width: 248px;margin-left: 10px;margin-bottom:15px;margin-top: 0px;"><h4><?php

                    $date = new DateTime($list_time);
					$list_time = $date->format('Y-m-d');

		         echo $list_name ; ?></h4></div>
		        <div style="color: #606060; width: 200px;margin-left: 10px;margin-bottom:15px;margin-top: -10px;"><h6><?php echo"created on ".$list_time;?></h6></div>
		</div></a>
		       
<?php 
	}
	}

	else
		{
			echo "<center style='margin-left:330px;margin-top:250px;margin-right:435px;margin-bottom:200px;color:rgba(0,0,0,0.6)'><h3>There are no playlists yet!<h3><center>";
		}?>
      </div>
    </div>	
     
       <!--End Display Playlists  -->
    <!-- upload file php code -->

<?php } ?>
	<?php 
    	
    		if(isset($_POST['add_playlist'])){
    			
    		$playlist_title = htmlentities($_POST['playlist_title']);
	        $playlist_image = $_FILES['playlist_image']['name'];
	        $image_tmp = $_FILES['playlist_image']['tmp_name'];
	        $random_number = rand(1,500);
	        $videos = 0;
	        $privacy = 1;
	        if($playlist_image=='')
	        {
			    $playlist_image = 'default_playlist_image.jpg';
			}
			$FileType = strtolower(pathinfo($playlist_image,PATHINFO_EXTENSION));

	      	if($playlist_title==''){
	        	echo "<script>alert('Please enter title for your playlist!')</script>";
	        	echo "<script>window.open('playlists.php?u_id=$user_id','_self')</script>";
	        	exit();
	      	}else{

			      	 if ($FileType =='png' || $FileType =='jpg' || $FileType =='jpeg' || $FileType =='tif')
			      	  {
			          	if ($playlist_image != 'default_playlist_image.jpg') {
			          	   move_uploaded_file($image_tmp,"includes/doc_attachments/playlist/playlists_image/$playlist_image.$random_number");
			          	}

			          	if ($playlist_image == 'default_playlist_image.jpg') {
			          		$insert = $con->prepare("INSERT into playlist(list_name,list_pic,list_videos,privacy,user_id)values('$playlist_title','$playlist_image','$videos','$privacy','$userown_id')");
			          	}
			          	else
			          	{
			          		$insert = $con->prepare("INSERT into playlist(list_name,list_pic,list_videos,privacy,user_id)values('$playlist_title','$playlist_image.$random_number','$videos','$privacy','$userown_id')");
			          	}
					  	

					  	$insert ->execute();                
			         	if($insert){
			          	 //echo "<script>alert('playlist added!')</script>";
			          	echo "<script>window.open('playlists.php?u_id=$user_id','_self')</script>";
			          	}
			          }
			          else
			          {

			      	  	echo "<script>alert('Please Select file with just png,jpg,jpeg or tif format')</script>";
			        	echo "<script>window.open('playlists.php?u_id=$user_id','_self')</script>";
			        	exit();
			          }
	        }
	    }
	?>
	<?php
	include 'includes/templates/footer.php';
?>
		              <!-- <div  style="width: 225px;height: 210px;" class="videocard shadow ">
		               
		              </div> -->