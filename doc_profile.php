<?php
	session_start();
	$pageTitle = "Profile" ; 
	$noNavbar = ''; 
	include("initialize.php");

	if(!isset($_SESSION['user_email'])){
		header("location: index.php");
	}else{ 
?>

<head>
	<link rel="stylesheet" href="layout/css/Bootstrap v3.3.7 bootstrap.min.css"/>
	<link rel="stylesheet" href="mystylesheet.css">
	<meta charset="utf-8">
	<link rel="stylesheet" href="ratings/jquery/jRating.jquery.css" />
	<style>
		.hideuserrate{
		display: none;
		}
	</style>
	<script type="text/javascript" src="ratings/jquery/jquery.js"></script>
	<script type="text/javascript" src="ratings/jquery/jRating.jquery.js"></script>
</head>

<?php

	$user_id = isset($_GET['u_id']) && is_numeric($_GET['u_id']) ? intval($_GET['u_id']) : 0 ;

	$stmt = $con->prepare("SELECT * FROM users WHERE user_id = ? AND GroupID = '2'");
	$stmt->execute(array($user_id));
	$row = $stmt->fetch();
	$count = $stmt->rowCount();

	if($count > 0 ){
		$id = $row['user_id'];
		$name = $row['user_name'];
		$f_name = $row['f_name'];
		$l_name = $row['l_name'];
		$address = $row['address'];
		$user_email =$row['user_email'];
		$describe_user = $row['describe_user'];
		$gender = $row['user_gender'];
		$register_date = $row['user_reg_date'];
		$user_country = $row['user_country'];
		$user_birthday = $row['user_birthday'];
		$user_image = $row['user_image'];
		$user_cover = $row['user_cover'];
		$private_chat = $row['private_chat'];

		/* Check IF User Is Owner User */
		$user = $_SESSION['user_email'];
		$get_user  = $con->prepare("SELECT * from users where user_email='$user'");
		$get_user  ->execute();
		$row = $get_user  ->fetch();	
		$userown_id = $row['user_id'];
		$user_name = $row['user_name'];
		$type = $row['GroupID'];

?>





<div class="container">
	<!-- Start Cover And Pic Profile Area -->
	<div class="row">
		<div class="col-sm-1"> </div>
		<div class="col-sm-10">
			<div class="cover">
				<img 
					class='cover-img' 
					src='includes/images/cover/<?php if(!empty($user_cover)){ echo $user_cover; }else{ echo 'default_cover.png'; } ?>' 
					alt='cover Pic'
				/>
				<?php if($id == $userown_id){ ?>
					<form action='doc_profile.php?u_id=<?php echo $id ?>' method='POST' enctype='multipart/form-data'>
						<ul class='nav cover-ul pull-left'>
					    	<li class='dropdown'>
					        	<button class='dropdown-toggle btn btn-default' data-toggle='dropdown'>Change Cover</button> 
					        	<div class='dropdown-menu'>
					        		<center>
						        		<p> Click <strong>Select Cover</strong> and then click the <br> <strong>Update Cover</strong></p>
						            	<label class='btn btn-info'> Select Cover
								        <input type='file' name='user_cover' size='60' />
								        </label><br><br>
						                <button name='submit' class='btn btn-info'>Update cover</button>
					            	</center>
					            </div>
					        </li>
					    </ul>
		          	</form>
				<?php }?>
          	</div>
         	<div class="profile">
	            <img 
	            	src='includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.png'; } ?>' 
	            	class='img-circle docprofileimg'
	            	alt='Profile' 	 
	            />
	            <?php if($id == $userown_id){ ?>
		            <form action='doc_profile.php?u_id=<?php echo $id ?>' method='POST' enctype='multipart/form-data'>
						<ul class='nav photo-ul pull-left'>
					    	<li class='dropdown'>
					        	<button class='dropdown-toggle btn btn-default' data-toggle='dropdown'>Change Picture</button> 
					        	<div class='dropdown-menu'>
					        		<center>
					        		<p> Click <strong>Select Picture</strong> and then click the <br> <strong>Update Picture</strong></p>
					            	<label class='btn btn-info'> Select Cover
							        <input type='file' name='u_image' size='60' />
							        </label><br><br>
					                <button name='update' class='btn btn-info'>Update Profile</button>
					            	</center>
					            </div>
					        </li>
					    </ul>
		          	</form>
	          	<?php }?>
          	</div>
	    </div>
	    <div class="col-sm-1"> </div>
	</div><br/>	    
	<?php 
	    if(isset($_POST['submit'])){
	        $user_cover = $_FILES['user_cover']['name'];
	        $image_tmp = $_FILES['user_cover']['tmp_name'];
	        $random_number = rand(1,100);

	      	if($user_cover==''){
	        	echo "<script>alert('Please Select Cover Image!')</script>";
	        	echo "<script>window.open('doc_profile.php?u_id=$id','_self')</script>";
	        	exit();
	      	}else{              
	          	move_uploaded_file($image_tmp,"includes/images/cover/$user_cover.$random_number");
			  	$update = $con->prepare("UPDATE users SET user_cover='$user_cover.$random_number' WHERE user_id='$id' ");
			  	$update ->execute();                
	         	if($update){
	          	echo "<script>alert('Your Cover Updated!')</script>";
	          	echo "<script>window.open('doc_profile.php?u_id=$id','_self')</script>";
	          	}
	        }
	    }
	    if(isset($_POST['update'])){
		    $u_image = $_FILES['u_image']['name'];
		    $image_tmp = $_FILES['u_image']['tmp_name'];
		    $random_number = rand(1,100);
	 	    if($u_image==''){
	    	    echo "<script>alert('Please Select Profile Image on clicking on the profile image area!')</script>";
	        	echo "<script>window.open('doc_profile.php?u_id=$id','_self')</script>";
	       		exit();
	      	}else{  
	          	move_uploaded_file($image_tmp,"includes/images/users/$u_image.$random_number");
			  	$update = $con->prepare("UPDATE users SET user_image = '$u_image.$random_number' WHERE user_id = '$id' ");
			  	$update ->execute();                
	          if($update){
	          	echo "<script>alert('Your Profile Updated!')</script>";
	          	echo "<script>window.open('doc_profile.php?u_id=$id','_self')</script>";
	          }
	        }
	    }
	?>
	<!-- End Cover And Pic Profile Area -->
	
	<!-- Start Doctor Name Area -->
	<div class="container">
		<div class="Docnamearea">
			<div class="row">
				<div class="col-sm-1"></div>
				<div class="col-sm-4">
					<h3 class="Docname" style="margin-top: 0px ;font-size:27px;display: inline-block;">DR.<strong> <?php echo $f_name .' '. $l_name; ?></strong></h3>
				</div>	
				<div class="col-sm-3">	
					<!-- Start Rate -->
						<?php 
							$stmt = $con->prepare("SELECT Rate FROM rate WHERE Doc_ID = $user_id");
							$stmt->execute(array($user_id));
							$row = $stmt->fetch();
							$count = $stmt->rowCount();

							$stmt = $con->prepare("SELECT SUM(Rate) AS total FROM rate WHERE Doc_ID = $user_id");
							$stmt->execute();
							$row = $stmt->fetch(PDO::FETCH_ASSOC);
						?>

					    <div style="text-align: center; color:#31b0d5;font-size:20px;display: inline; margin-left: 40px">					    	
				          <?php 
				         	if ($row['total'] && $count) {
				         		$average = $row['total']/$count;
				         	 	echo round($average,1);
				         	}else{
				         		echo 1;
				         	}
				          ?> 
				           <i style="color:#31b0d5;" class="fa fa-star fa-1x"></i>
						</div>

						<!-- Start rate Popup -->
						<center>
						<div class="modal" id="rate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:200px;">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						        <form action="doc_profile.php?u_id=<?php echo $user_id ?>" method='POST' enctype='multipart/form-data' style="display: inline-flex;">
						        		<div align="center" style="margin-top:14px;margin-right:10px;">
									        <i class="fa fa-star fa-2x hav" data-index="0"></i>
									        <i class="fa fa-star fa-2x hav" data-index="1"></i>
									        <i class="fa fa-star fa-2x hav" data-index="2"></i>
									        <i class="fa fa-star fa-2x hav" data-index="3"></i>
									        <i class="fa fa-star fa-2x hav" data-index="4"></i>
									    </div>
									<textarea style="display:none;" type="hidden" name="my_rate" id="myrate"></textarea>
					    			<button name="saverate" class="btn btn-info" style="max-height:40px;margin-top: 15px; margin-right:15px;"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
					    <script src="http://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
					    <script>
					        var ratedIndex = -1, uID = 0, doc_ID= "<?php echo $user_id; ?>", user_ID= "<?php echo $userown_id; ?>";

					        $(document).ready(function () {
					            resetStarColors();

					            $('.hav').on('click', function () {
					               ratedIndex = parseInt($(this).data('index'));
					               localStorage.setItem('ratedIndex', ratedIndex);
					               document.getElementById('myrate').innerHTML = ratedIndex;
					               // window.alert(ratedIndex);
					            });
					            $('.hav').mouseover(function () {
					                resetStarColors();
					                var currentIndex = parseInt($(this).data('index'));
					                setStars(currentIndex);
					            });

					            $('.hav').mouseleave(function () {
					                resetStarColors();

					                if (ratedIndex != -1)
					                      setStars(ratedIndex);
					            });
					        });

					        function setStars(max) {
					            for (var i=0; i <= max; i++)
					                $('.hav:eq('+i+')').css('color', '#31b0d5');
					        }

					        function resetStarColors() {
					            $('.hav').css('color', 'gray');
					        }
					    </script>
					    			
					   	      	</form>
						    </div>
						  </div>
						</div>
					</center>
					<?php
					    if (isset($_POST['saverate'])) {
					        $ratedIndex =$_POST['my_rate'];
					        $ratedIndex++;

					        if (1) {
									$insert = $con->prepare("INSERT into rate(Doc_ID,User_ID,Rate)values('$user_id','$userown_id','$ratedIndex')");
									$insert ->execute();                
								    if($insert){
							        // echo "<script>alert('rating added')</script>";
								       //  echo "<script>alert($ratedIndex)</script>";
						
								          	}
								    else
								    {
								        echo "<script>alert('can't add rate)</script>";

								    }
					        } else
					            $conn->query("UPDATE stars SET rateIndex='$ratedIndex' WHERE id='$uID'");

					    }
					?>
						<!-- End rate Popup -->
					<!-- End Rate -->

				</div>
				<div class="col-sm-3">	
					<div class="" style="float: right;margin-right: 25px">
					<?php if($id != $userown_id){?>
						<a class="btn btn-info" href='#' data-toggle='modal' data-target='#rate' data-whatever='@mdo'><i class="fa fa-star-o" aria-hidden="true"></i> Rate</a>
						<a class="btn btn-default" href=""><i class="fa fa-user-times" aria-hidden="true"></i> Report</a>
					<?php }?>
					</div>
				</div>
				<div class="col-sm-1"></div>
			</div>
		</div>
	</div>
	<!-- End Doctor Name Area -->

	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<ul class="nav nav-pills docnav">
			  <li class="active"><a data-toggle="pill" href="#home">Home</a></li>
			    <li style="margin-left:0px;"><?php 
		      		if($id != $userown_id){
						echo"<a href='#' data-toggle='modal' data-target='#exampleModal' data-whatever='@mdo'/>Ask Private</a>";
					}else{
							echo"<a data-toggle='pill' href='#menu1'>Private Question</a>";	
					}?>				
				</li> 			
				<li class="dropdown" style="margin-left:0px;">
			      <a href="#" class='dropdown-toggle' data-toggle='dropdown'><span>Attachments <i class='glyphicon glyphicon-triangle-bottom gl-navdoc'></i></span></a>
			      <ul class='dropdown-menu'>
			        <li>
			       		<form action='doc_folders.php?u_id=<?php echo $id ?>' method='POST' enctype='multipart/form-data'>
			        		<button class='btn btn-info btn-attachment'>Files</button>
						</form>
			        </li>			      	
			        <li>
			       		<form action='playlists.php?u_id=<?php echo $id ?>' method='POST' enctype='multipart/form-data'>
			        		<button class='btn btn-info btn-attachment'>Playlists</button>
						</form>
			        </li>
			      </ul>
				</li>	    
				<?php if ($id == $userown_id) { ?>
			    <li style="margin-left:0px;"><a data-toggle="pill" href="#private_chat" >Chat</a></li>
				<?php }else{
						    if ($private_chat == 0) {?> 
			  		  			<li style="margin-left:0px;"><a data-toggle="pill" href="#private_chat_user" >Chat</a></li>
							<?php }else{ ?>
			    				<li style="margin-left:0px;"><a href="user_private_chat.php?u_id=<?php echo $id; ?>">Chat</a></li>
							<?php }}?>
			   <li style="margin-left:0px;"><a data-toggle="pill" href="#menu3">About</a></li>
			</ul>
		</div>
		<div class="col-sm-1"></div>
	</div>



<div class="tab-content">
   <div id="home" class="tab-pane fade in active">
   		<center><h1><strong>Home</strong></h1><br></center>
    <div class='row'>
	  <div class='col-sm-2'> </div>
	<!-- Start Displaying Users own Posts-->
	  <div class="col-sm-8">
		<!-- Start Display Posts -->
			<?php
			$select_posts = $con->prepare("SELECT * from posts where user_id='$id' ORDER BY post_id Desc");
			$select_posts ->execute();
			$posts = $select_posts ->fetchAll();
			foreach ($posts as $key => $post){
				$post_id   = $post['post_id'];
				$user_id   = $post['user_id'];
				$content   = $post['post_content'];
				$post_date = $post['post_date'];

				//getting the user who has posted the post
				$select_user = $con->prepare("SELECT * FROM users WHERE user_id = ? AND posts='yes' ");
				$select_user ->execute(array($id));
				$row_user    = $select_user ->fetch();
				$user_name  = $row_user['user_name'];
				$user_image = $row_user['user_image'];
				$user_type = $row_user['GroupID'];

				$share_post = "postDetails.php?post_id=";
			?>
			<!-- Start Post Body -->
				<div class="post">
					<!-- Start Post's User Info  -->
					<div class='row'>
						<div class='col-sm-10 user'>
							<img src='includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.png'; } ?>'>
							<?php				
								if($user_type == 2 ){
					    			echo "<a class='name' href='doc_profile.php?u_id=$id'>$user_name</a>";
					    		}else{
					    			echo "<a class='name' href='user_profile.php?u_id=$id'>$user_name</a>";
					    		}
							?>	
							<p class="date">Updated a post on <strong><?php echo $post_date ?></strong></p>
						</div>
						<div class='col-sm-2 owner-action'>
						<?php if($id == $sessionuser_id){?>
							<a href="post.php?do=edit&post_id=<?php echo $post_id ?>" class=" edit" title="Edit" ><i class="fa fa-pencil" aria-hidden="true"></i></a>
							<a href="post.php?do=delete&post_id=<?php echo $post_id ?>" class="delete" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
						<?php } ?>	
						</div>
					</div>
					<!-- End Post's User Info  -->
					<!-- Start Post Content -->
					<div class='row'>
						<div class='col-sm-1'> </div>
						<div class='col-sm-10 content' >
							<p><?php echo $content ?></p>
						</div>
						<div class='col-sm-1'></div>
					</div>
					<!-- End Post Content -->
					<!-- Start Post Button Action -->
					<div class="post-button">
						<!-- Start Like Button -->
				      	<i 
				      	  <?php if (userLiked($post_id) ){?>
				      		  class="fa fa-thumbs-up fa-7x like-btn"
				      	  <?php }else{ ?>
				      		  class="fa fa-thumbs-o-up fa-7x like-btn"
				      	  <?php } ?>
				      	  data-id="<?php echo $post_id; ?>">
				      	</i>
				      	<span class="likes numLikes"><?php echo getLikes($post_id); ?></span>
					    <script src="layout/js/scripts.js"></script>
					    <!-- End Like Button -->
					    <!-- End Like Button -->
						<a href='post.php?do=postDetails&post_id=<?php echo $post_id ?>' class='show-btn btn btn-info'>Comment</a>	
						<div class="share-area">
						  <div id="popover-div" class="col-sm-12 col-xs-12 col-md-9">
						    <buttom id="share" class="btn btn-info change-trigger" data-original-title="Share a link to this post">Share</buttom>        
						    <div class="hide" id="html-div">
						      <form class="share-form">
						        <div class="form-group">
						          <input class="form-control share-link" id="post_link" type="text" readonly=""  value="<?php echo $share_post.$post_id ?>"/>
						        </div>
						        <div class="form-group">
						          <a onclick="myFunction()" id="copy" class="share-copy-button btn btn-info">Copy link</a>
		 				        </div>
						      </form>
						    </div>
						  </div>
						</div>
					</div>
					<!-- End Post Button Action -->
				</div><br>
			<!-- End Post Body -->
			<?php } ?>
		<!-- End Display Posts -->
	  </div>	
	  <div class='col-sm-2'> </div>
    </div>
   </div>

    <!-- Private Chat -->
    <div id="menu1" class="tab-pane fade">
	    <?php 
	  		if($id != $userown_id){
				echo"<a href='#' class='btn btn-info multi-btn'data-toggle='modal' data-target='#exampleModal' data-whatever='@mdo'/>Ask Private</a>";
			}else{
		?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
		<center><h2><strong>Private Quetions</strong></h2><br></center>
		
		<?php
		/* Get User ID */
		$user = $_SESSION['user_email'];
		$get_user  = $con->prepare("SELECT * from users where user_email='$user'");
		$get_user  ->execute();
		$row = $get_user  ->fetch();	
		$userown_id = $row['user_id'];
		$user_name = $row['user_name'];
				
		$get_posts = $con->prepare("SELECT * From posts WHERE postType = 3 AND PrivateTo = $userown_id");
		$get_posts ->execute();
		$posts = $get_posts ->fetchAll();
		$count = $get_posts ->rowCount();	

		foreach ($posts as $post){

			$post_id   = $post['post_id'];
			$user_id   = $post['user_id'];
			$content   = $post['post_content'];
			$post_date = $post['post_date'];

			//getting the user who has posted the post
			$select_user = $con->prepare("SELECT * FROM users WHERE user_id = ? AND posts='yes' ");
			$select_user ->execute(array($user_id));
			$row_user    = $select_user ->fetch();
			$user_name  = $row_user['user_name'];
			$user_image = $row_user['user_image'];
			$user_type = $row_user['GroupID'];

			$share_post = "postDetails.php?post_id=";

		?>

		<!-- Start Post Body -->
		<div class='row'>
			<div class='col-sm-2'> </div>
			<div class='col-sm-8 post'>
				<!-- Start Post's User Info  -->
				<div class='row'>
					<div class='col-sm-10 user'>
						<img src='includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.png'; } ?>'>
						<?php				
							if($user_type == 2 ){
				    			echo "<a class='name' href='doc_profile.php?u_id=$user_id'>$user_name</a>";
				    		}else{
				    			echo "<a class='name' href='user_profile.php?u_id=$user_id'>$user_name</a>";
				    		}
						?>	
						<p class="date">Updated a post on <strong><?php echo $post_date ?></strong></p>
					</div>
					<div class='col-sm-2 owner-action'>
					<?php if($user_id == $sessionuser_id){?>
						<a href="post.php?do=edit&post_id=<?php echo $post_id ?>" class=" edit" title="Edit" ><i class="fa fa-pencil" aria-hidden="true"></i></a>
						<a href="post.php?do=delete&post_id=<?php echo $post_id ?>" class="delete" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
					<?php } ?>	
					</div>
				</div>
				<!-- End Post's User Info  -->
				<!-- Start Post Content -->
				<div class='row'>
					<div class='col-sm-1'> </div>
					<div class='col-sm-10 content' >
						<p><?php echo $content ?></p>
					</div>
					<div class='col-sm-1'></div>
				</div>
				<!-- End Post Content -->

				<!-- Start Post Button Action -->
				<div class="post-button">
					<!-- Start Like Button -->
			      	<i 
			      	  <?php if (userLiked($post_id) ){?>
			      		  class="fa fa-thumbs-up fa-7x like-btn"
			      	  <?php }else{ ?>
			      		  class="fa fa-thumbs-o-up fa-7x like-btn"
			      	  <?php } ?>
			      	  data-id="<?php echo $post_id; ?>">
			      	</i>
			      	<span class="likes numLikes"><?php echo getLikes($post_id); ?></span>
				    <script src="layout/js/scripts.js"></script>
				    <!-- End Like Button -->
				    <!-- End Like Button -->
					<a href='post.php?do=postDetails&post_id=<?php echo $post_id ?>' class='show-btn btn btn-info'>Comment</a>	
					<div class="share-area">
					  <div id="popover-div" class="col-sm-12 col-xs-12 col-md-9">
					    <buttom id="share" class="btn btn-info change-trigger" data-original-title="Share a link to this post">Share</buttom>        
					    <div class="hide" id="html-div">
					      <form class="share-form">
					        <div class="form-group">
					          <input class="form-control share-link" id="post_link" type="text" readonly=""  value="<?php echo $share_post.$post_id ?>"/>
					        </div>
					        <div class="form-group">
					          <a onclick="myFunction()" id="copy" class="share-copy-button btn btn-info">Copy link</a>
	 				        </div>
					      </form>
					    </div>
					  </div>
					</div>
				</div>
				<!-- End Post Button Action -->
			</div>
			<div class='col-sm-2'> </div>
		</div><br>
		<!-- End Post Body -->
   <?php } ?>
		</div>
	</div>
</div>


				<?php } ?>
    </div>
    <!-- End Private Chat -->



	<div id="private_chat_user" class="tab-pane fade in " style="">
		<center><h3 style="margin-left: 20px;margin-bottom: 50px;">Doctor <?php echo $f_name; ?> disactive his privte chat <i class="fa fa-frown-o fa-1x" aria-hidden="true"></i></h3></center>
    </div>
    
    <?php if ($private_chat == 1) { ?>

    		<!-- get booked chats -->
			<div id="private_chat" class="tab-pane fade in " style="">
				<div class="container">
				<?php
				if($private_chat == 1){
				?>	
					<div class="row">
						<div class="col-sm-1"></div>
						<div class="col-sm-10">
							<h3 id="hearder_chat_yes">People booked this chats with you </h3>
				  	<!-- get private chats -->
				  	<?php 
						$private = $con->prepare("SELECT * from coming_private_chat where doc_id='$id' ORDER by 1 Desc ");
						$private ->execute();
						$chats = $private ->fetchAll();	
						$count = $private->rowCount();
						if($count > 0 ){
						foreach ($chats as $key => $row_chat){
							$chat_id = $row_chat['id'];
							$doc_id = $row_chat['doc_id'];
							$final_day = $row_chat['final_day'];
							$final_month = $row_chat['final_month'];
							$final_year = $row_chat['final_year'];
							$day_char = $row_chat['day_char'];
							$start_chat = $row_chat['start_chat'];
							$start_minutes = $row_chat['start_minutes'];
							$am_pm = $row_chat['am_pm'];
							$was_booked_on = $row_chat['was_booked_on'];
							$duration = $row_chat['duration'];
							$cost = $row_chat['cost'];
							if (!$start_minutes) {
								$zero = 0;
							}

				  	?>
				  	<?php 
							$stmt = $con->prepare("SELECT * FROM users WHERE user_id = $doc_id");
							$stmt->execute(array());
							$row = $stmt->fetch();
							if($count > 0 ){
								$name = $row['user_name'];
								$doc_f_name = $row['f_name'];
								$doc_l_name = $row['l_name'];}
				  	?>
				   	<div class="col-sm-3" style="background-color:#eee!important;margin-right: 10px;width: 260px;margin-top: 20px;margin-bottom:20px;border-radius: 5px;border: solid 1px;border-color: #31b0d5;">
						<h4 style="text-align:center;margin-top: 7px;font-weight: bold;">Chat Details</h4>
				   		<p>DR:&nbsp;<strong><a href="doc_profile.php?u_id=<?php echo $doc_id; ?>"><?php echo $doc_f_name.' '.$doc_l_name; ?></a></strong></p>
				   		<p>Date:&nbsp;<strong><a style="text-decoration: none;"><?php echo $final_day.'/'.$final_month.'/'.$final_year; ?></a></strong></p>
				   		<p>Day:&nbsp;<strong><a style="text-decoration: none;"><?php echo $day_char; ?></a>&nbsp; at &nbsp;<a style="text-decoration: none;"><?php  if(!$start_minutes){echo $start_chat.':'.$start_minutes.$zero.' '.$am_pm;}else{echo $start_chat.':'.$start_minutes.' '.$am_pm;}  ?></a></strong></p>
				   		<p>Duration:<strong><a style="text-decoration: none;"><?php echo $duration.' '.'Minutes'; ?></a></strong></p>
				   		<p>Cost:<strong><a style="text-decoration: none;"><?php echo ' '.$cost.' '.'$'; ?></a></strong></p>
				   		<p>Booked on:&nbsp;<strong><a style="text-decoration: none;"><?php echo $was_booked_on; ?></a></strong></p>
				   		<center><a href="private_chat.php?chat_id=<?php echo $chat_id; ?>"><button class="btn btn-info" style="margin-bottom: 5px;">Go to chat</button></a></center>
				    </div>
					<?php }} ?>
						</div>
					</div>
				<?php	
				}else{
				?>	
				<div class="row">
					<div class="col-sm-1"></div>
					<div class="col-sm-10">
						<h3 id="hearder_chat_no" class="nowtext" >there are no chats booked yet &nbsp;<i class="fa fa-frown-o fa-1x" aria-hidden="true"></i></h3>
					</div>
				</div>
				<?php
				}
				?>
				<div class="row">
					<div class="col-sm-1"></div>
					<div class="col-sm-10">
						<a href="doc_chat_settings.php?u_id=<?php echo $id;?>" style="float:right; font-size: 20px; margin-bottom: 30px;"><i class="fa fa-cog" aria-hidden="true"></i> 
						change private chat setting</a>
					</div>
				</div>
						

				</div>
			</div>





<?php } else{ ?>
	<div style="margin-bottom: 50px;" id="private_chat" class="tab-pane fade in ">
		<center>
			<center style="display: inline-flex;">
			<h3>You should change your private chat setting </h3>
			<a href="doc_chat.php?u_id=<?php echo $id; ?>"><i style="margin-left: 20px;margin-top: 15px;" class="fa fa-cog fa-3x"></i></a>
			</center>
	    </center>
	</div>
<?php } ?>

    <div id="menu3" class="tab-pane fade">
    <!-- Start Doctor Information -->
	<div class="information">
			<center><h1><strong>About</strong></h1><br></center>
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
				<div class="panel panel-info">
					<div class="panel-heading"> Doctor Information </div>
					<div class="panel-body">
						<ul class="list-unstyled">
							<li>
								<i class="fa fa-user-circle" aria-hidden="true"></i>
								<span>Name </span>: <strong> <?php echo $f_name .' '. $l_name; ?></strong>
							</li>
							<li>
								<i class="fa fa-id-card" aria-hidden="true"></i>
								<span>Bio </span>: <?php echo $describe_user;  ?>
							</li>
							<li>
								<i class="fa fa-envelope-o fa-fw"></i>
								<span>Email </span>: <?php echo $user_email; ?>
							</li>
							<li>
								<i class="fa fa-globe" aria-hidden="true"></i>
								<span>Country </span>: <?php echo $user_country; ?>
							</li>
							<li>
								<i class="fa fa-calendar fa-fw"></i>
								<span>Register Date </span>: <?php echo $register_date; ?>
							</li>
							<li>
								<i class="fa fa-map-marker" aria-hidden="true"></i>
								<span> Address </span>: <?php echo $address?>
							</li>							
						</ul>
						<?php		
							if($id == $userown_id){
								echo"<a href='edit_profile.php?u_id=$userown_id' class='btn btn-default'/><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Edit Information</a>";
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Doctor Information -->
    </div>

  </div>
</div>


	<!-- Start Private Post Popup -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<h4 class="modal-title" id="exampleModalLabel" style="display:inline-block">Ask Your Question</h4>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form action="post.php?do=private" method="POST">
	        	<input type="hidden" name="doc_id" value="<?php echo $id ?>"/>
	          <div class="form-group">
	            <label for="message-text" class="col-form-label">Message:</label>
	            <textarea class="form-control" id="message-text" name="content"rows="4"></textarea>
	          </div>
	      </div>
	      <div class="modal-footer">
	      	<input type="submit" value="Send message" name="message" class="btn btn-info"/>
	      	</form>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End Private Post Popup -->



<?php }else{
	    echo "<script>alert('There Is No ID Exist !')</script>";
        echo "<script>window.open('home.php','_self')</script>";
} ?>
<?php } ?>

<?php
	include 'includes/templates/footer.php';				
?>
 

