
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

	$stmt = $con->prepare("SELECT * FROM users WHERE user_id = '$current_user_id ' AND type = '1'");
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
<div style="height: 280px; width: 140px; background-color: #CCC;margin-left: -2px;margin-top:130px;border-top-right-radius:8px;border-bottom-right-radius:8px; position: fixed;">

		<div style="margin-top: -180px;" class="profile">
			<a href='doc_profile.php?u_id=<?php echo $id;?>' title="view profile" style="text-decoration: none;"><img 
				src='includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.png'; } ?>' 
				            	class='img-circle'
				            	alt='Profile' 	 
				            	width='50px' 
				            	height='50px' 
			 /><?php echo "<h5 style='margin-left:-13px;font-weight:bold;color:black;'>$f_name</h5>"; ?></a>
		</div>
	<form action='playlists.php?u_id=<?php echo $id ?>' method='POST' enctype='multipart/form-data'>
		<center style="margin-top: 100px;">
		    <button style="background-color:#DDDDDD font-weight:bold;width: 120px;border-bottom-right-radius: 20px;border-top-right-radius: 20px;" class='btn btn-info'>Playlists</button>
		</center>
	</form>
	<form action='doc_folders.php?u_id=<?php echo $id ?>' method='POST' enctype='multipart/form-data'>
		<center style="margin-top: 10px;">
		    <button style="font-weight:bold;width: 120px;border-bottom-right-radius: 20px;border-top-right-radius: 20px;" class='btn btn-info'>Files</button>
		</center>
	</form>
	</div>




    <div style=" width: 1150px;height: 537px; margin-left: 170px;margin-right: 10px;display: inline-flex;" class="card shadow mb-4"> 


    <!-- start display playlists -->
			<div  style="display:inline-flex; background-color: #F1F1F1; padding-left: 0rem;" class="card-body">
				<div>
				<video style=" margin-top: 2px; margin-left: 40px;margin-right:20px;" width="620" height="350" controls="">
					<source src="includes/doc_attachments/playlist/videos/<?php echo $current_video;?>" type="">
				</video><br>
				<div id="example"><i style=" margin-left:40px;margin-top:5px;margin-bottom:-15px;" class="fa fa-th fa-2x"></i></div>

			<script>

				$(document).ready(function() {
				    $("#example").popover({
				        placement: 'left',
				        html: 'true',
				         content:'<button class="btn" style="padding:7px;padding-right:17px;color:blue;" type="button" data-toggle="modal" data-target="#edit" data-whatever="@mdo"><i class="fa fa-edit"> Edit Video</i></button> <br> <button style="padding:7px;margin-top:5px;color:red;" class="btn" type="button" data-toggle="modal" data-target="#delete" data-whatever="@mdo"><i class="fa fa-times"> Delete Video</i></button>',
				        
				    	});
					});  
			</script>


			               <div style="width: 600px; margin-left: 45px; margin-top: 15px;">
			              		<?php 								 
			              		$date = new DateTime($current_video_time);
								    $current_video_time = $date->format('Y-m-d');

			              			echo "<h3 style='color:
			              			Balck;font-size:30px;'>$current_video_title</h3>

			              			<p style='color:#606060'>$current_video_views  Views <strong>.</strong> 
			              			     $current_video_time
			              			</p><br><br>
			              			<p style='font-size:15px;'>$current_video_desc</p>
			              				";
			              		?>
			               </div>			        
			            </div>   

			        <?php 
					    $stmt = $con->prepare("SELECT * FROM playlist WHERE list_id = $playlist_id ");
						$stmt->execute();
						$rows = $stmt->fetch();
						if ($rows>0) {
							$list_name = $rows['list_name'];
						}

			        ?>

			<div style="float: right; width: 430px;">           
			    <div>
			    	 <div style="width: auto;margin-left: 15px;margin-right: -8px;" class="card shadow ">

			    	 	<div class="card-header" style="width:430px;height:55px;margin-top: 0px;margin-left: 0px;">
			    	 		<h4 style="margin-left:10px;"> <?php echo $list_name; ?> </h4>	
			    	 	</div>

			              <div class="card-body" style="border-radius:8px;border-top-right-radius:0px; background-color:white;overflow-y:auto; overflow-x:hidden; padding-top: 8px; width: 430;height: 500px;margin-top: 0px; margin-right: 20px;">
					<?php 
					$counter =1;
					    $stmt = $con->prepare("SELECT * FROM video WHERE playlist_id = $playlist_id ");
						$stmt->execute();
						$rows = $stmt->fetchAll();
						$count = $stmt->rowCount();
						if($count > 0 ){
							foreach ($rows as $key => $row){
							$thisvideo_id = $row['video_id'];
							$video_pec    = $row['video_pic'];
							$video_tittle = $row['video_title'];
							$video_duration_hours	= $row['video_duration_hours'];
							$video_duration_minutes	= $row['video_duration_minutes'];
							$video_duration_seconds	= $row['video_duration_seconds'];

						
			        ?>
			                <a href="display_video.php?v_id=<?php echo $thisvideo_id;?>" title="Play Now" style="text-decoration: none;">
			      				
			      			<?php 
			      				if ($video_id == $thisvideo_id) {
			      					echo "
			      				<div class='card-body hov' style='background-color:rgba(0,0,0,0.1); display: inline-flex; width: 455px;height: 77px;margin-top: 0px; padding:0rem;margin-left: -11px;'>";
			      				}
			      				else
			      				{
			      			?>
			              	<div class="card-body hov" style=" display: inline-flex; width: 455px;height: 77px;margin-top: 0px; padding:0rem;margin-left: -11px;"  >
			              	<?php } ?>
			              		<?php 

			              			if ($video_id == $thisvideo_id) {
			              				echo"			                	 		<div style='width: 18px;height: 10px;''>
										  
										    <svg style='width: 30px;margin-top: 25px;margin-left: -8px;'' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 26 26'>
										      <polygon style='fill:rgba(0,0,0,0.5)' points='9.33 6.69 9.33 19.39 19.3 13.04 9.33 6.69'/>
										    </svg> 
										 
										</div>";
			              			}
			              			else
			              			{
			              				echo "<div style='width:16px; float: left;margin-left:2px;margin-top:25px; color: #b00917;''><h5>$counter</h5></div>";
			              			}

			             		 		$counter++;
			              		
			              		?>
			                <div style=" margin-left:5px; width: 130px;height: 75px; background-image: url('includes/doc_attachments/playlist/videos_pic/<?php echo $video_pec;?>');background-repeat: no-repeat;background-size: 100% 100%;">
			                	<div class="hov1" style="margin-top: -13px; height: 100%;width: 100%;"> 
			                		<div  style="background-color:rgba(0,0,0,0.7);width: auto;height: 22px; float: right;margin-top: 52px; margin-right: 3.5px; color: white;font-size: bold; padding: 1px;padding-top: -8px;">
			                			<center style="margin-top: -6px;"><h5>
			                				

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
			                	 		<div class="play-btn" style="width: 400%;height: 100%;">
										  
										    <svg style="width: 50px;margin-top: -60px;margin-left: 40px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26">
										      <polygon style="" class="play-btn__svg" points="9.33 6.69 9.33 19.39 19.3 13.04 9.33 6.69"/>
										    </svg> 
										 
										</div>

			                	</div>

			                <!-- <div style="margin-left:-12px; background-color: rgba(0,0,0,0.08); width: 475px;height: 2px;"></div> -->


			              </div>
			               <div style="color:black;font-weight: bold; width: 250px; margin-left: 10px; margin-top: 1px;">
			               	 <?php echo$video_tittle;
			               	  ?>
			               </div>
			              	</div>

			                	</a><br>

			                	<?php } ?>
			                </div>
			            
			        

			         </div>
			    </div>
			</div>           
					       
			<?php 
				
				}?>

			      </div>
    </div>	

<?php } ?>

	<!-- Start Edit Popup -->
	<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:50px;">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<center>
	      		<h4 class="modal-title" id="exampleModalLabel" style="display:inline-block;">Edit Video</h4>
	      		</h4>
	      	</center>
	        <button style="margin-top:-35px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">

	      	<center>
		    <form action='update_delete_video.php?v_id=<?php echo $video_id ?>' method='POST' enctype='multipart/form-data'>
		    	
			<span style="">

	                <label><h4 style="margin-top:30px;">video tittle</h4><input maxlength="102" value="<?php echo $current_video_title; ?>" class="form-control" type="text" name="video_title" required="" style=" width: 300px;border-radius:5px;"></label><br>

					<label style=""><h4 style="margin-left:25px;" >video descrption</h4><textarea value="<?php echo $current_video_desc; ?>" style="width: 300px;margin-left: 0px;" class="form-control" rows="4" name="video_desc"><?php echo $current_video_desc; ?></textarea></label><br>

				<div style="display:inline-flex;">
			        <button class="btn btn-info" style="margin-bottom: 60px;margin-top:20px;width:70px;border: solid 0.5px;" name='update_video'>Save</button>
			        <button class="btn btn-danger" style="margin-bottom: 60px;margin-top:20px;margin-left: 50px; width:70px;border: solid 0.5px;" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			    </div>
			</span>
		    </form>
		    </center>   
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End Edit Popup -->



	<!-- Start Delete Popup -->
	<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 100px;">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<center>
	      		<h4 class="modal-title" id="exampleModalLabel" style="display:inline-block;">Are you sure delete video ' <?php echo $current_video_title;?> '
	      		</h4>
	      	</center>
	        <button style="margin-top:-35px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">


	      	<form action='update_delete_video.php?v_id=<?php echo $video_id ?>' method='POST' enctype='multipart/form-data'>
	    	<center>
	    		
				<span style="display:inline-flex;">
			            <button  style="border:gray solid 0.5px; margin-right: 50px;margin-left:50px; height: 35px;" name='delete_video' class='btn btn-info'>Delete</butto>
			            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			    </span>
		       </span>
		    </center>
	        </form>    
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End Delete Popup -->


	<?php
	include 'includes/templates/footer.php';
?>
