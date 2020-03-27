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
</head>
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
		$describe_user = $row['describe_user'];
		$gender = $row['user_gender'];
		$register_date = $row['user_reg_date'];
		$user_country = $row['user_country'];
		$Relationship_status = $row['Relationship'];
		$user_birthday = $row['user_birthday'];
		$user_image = $row['user_image'];
		$user_cover = $row['user_cover'];

		/* Check IF User Is Owner User */
		$user = $_SESSION['user_email'];
		$get_user  = $con->prepare("SELECT * from users where user_email='$user'");
		$get_user  ->execute();
		$row = $get_user  ->fetch();	
		$userown_id = $row['user_id'];
		$user_name = $row['user_name'];

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
				<?php if($user_id == $userown_id){ ?>
					<form action='doc_profile.php?u_id=<?php echo $user_id ?>' method='POST' enctype='multipart/form-data'>
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
	            	class='img-circle'
	            	alt='Profile' 	 
	            	width='180px' 
	            	height='180px' 
	            />
	            <?php if($user_id == $userown_id){ ?>
		            <form action='doc_profile.php?u_id=<?php echo $user_id ?>' method='POST' enctype='multipart/form-data'>
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
	        	echo "<script>window.open('doc_profile.php?u_id=$user_id','_self')</script>";
	        	exit();
	      	}else{              
	          	move_uploaded_file($image_tmp,"includes/images/cover/$user_cover.$random_number");
			  	$update = $con->prepare("UPDATE users SET user_cover='$user_cover.$random_number' WHERE user_id='$user_id' ");
			  	$update ->execute();                
	         	if($update){
	          	echo "<script>alert('Your Cover Updated!')</script>";
	          	echo "<script>window.open('doc_profile.php?u_id=$user_id','_self')</script>";
	          	}
	        }
	    }
	    if(isset($_POST['update'])){
		    $u_image = $_FILES['u_image']['name'];
		    $image_tmp = $_FILES['u_image']['tmp_name'];
		    $random_number = rand(1,100);
	 	    if($u_image==''){
	    	    echo "<script>alert('Please Select Profile Image on clicking on the profile image area!')</script>";
	        	echo "<script>window.open('doc_profile.php?u_id=$user_id','_self')</script>";
	       		exit();
	      	}else{  
	          	move_uploaded_file($image_tmp,"includes/images/users/$u_image.$random_number");
			  	$update = $con->prepare("UPDATE users SET user_image = '$u_image.$random_number' WHERE user_id = '$user_id' ");
			  	$update ->execute();                
	          if($update){
	          	echo "<script>alert('Your Profile Updated!')</script>";
	          	echo "<script>window.open('doc_profile.php?u_id=$user_id','_self')</script>";
	          }
	        }
	    }
	?>
	<!-- End Cover And Pic Profile Area -->

	<!-- Start Doctor Information -->
	<div class="information">
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-8">
				<div class="panel panel-default">
					<div class="panel-heading"> Doctor Information </div>
					<div class="panel-body">
						<ul class="list-unstyled">
							<li>
								<i class="fa fa-user fa-fw"></i>
								<span>Name</span>:<strong> <?php echo $f_name .' '. $l_name; ?></strong>
							</li>
							<li>
								<i class="fa fa-envelope-o fa-fw"></i>
								<span>Bio</span>: <?php echo $describe_user ?>
							</li>
							<li>
								<i class="fa fa-user fa-fw"></i>
								<span>Full Name</span>:
							</li>
							<li>
								<i class="fa fa-calendar fa-fw"></i>
								<span>Register Date</span>:
							</li>
							<li>
								<i class="fa fa-tags fa-fw"></i>
								<span>g</span>:
							</li>							
						</ul>
						<?php		
							if($user_id == $userown_id){
								echo"<a href='edit_profile.php?u_id=$userown_id' class='btn btn-default'/>Edit Information</a>";
							}
						?>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<?php
					echo"<a href='#' class='btn btn-default multi-btn'/>Test</a>";
					echo"<a href='#' class='btn btn-default multi-btn'/>Test</a>";
					echo"<a href='#' class='btn btn-default multi-btn'/>Test</a>";
					echo"<a href='private_post.php' class='btn btn-default multi-btn'/>Private Questions</a>";			
					if($user_id != $userown_id){
						echo"<a href='#' class='btn btn-default multi-btn' data-toggle='modal' data-target='#exampleModal' data-whatever='@mdo'/>Ask Private</a>";
					}
				?>
			</div>
		</div>
	</div>
	<!-- End Doctor Information -->

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
	      	<input type="submit" value="Send message" name="message" class="btn btn-primary"/>
	      	</form>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- End Private Post Popup -->



	<div class='row'>
		<div class='col-sm-1'> </div>
	<!-- Start Displaying Users own Posts-->
	<div class="col-sm-8">
		<?php
			$get_posts = $con->prepare("SELECT * from posts where user_id='$user_id' ORDER by 1 DESC LIMIT 5");
			$get_posts ->execute();
			$posts = $get_posts ->fetchAll();	
			
			foreach ($posts as $key => $row_posts){

				$post_id = $row_posts['post_id'];
				$user_id = $row_posts['user_id'];
				$content = $row_posts['post_content'];
				$post_date = $row_posts['post_date'];
			
				$get_user = $con->prepare("SELECT * from users where user_id='$user_id' AND posts='yes'");
				$get_user ->execute();
				$user = $get_user ->fetch();				
				$user_name = $user['user_name'];
				$user_image = $user['user_image'];	 
		?>
		<div id='own_posts'>
			<div class='row'>
				<div class='col-sm-3'>
					<p><img src='includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.png'; } ?>' class='img-circle' width='100px' height='100px'></p>
				</div>
				<div class='col-sm-8'>
					<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;margin-left:15px ' href='doc_profile.php?u_id=$user_id'><?php echo $user_name?></a></h3>
					<h4><small style='color:black; margin-left:15px'>Updated a post on <strong><?php echo $post_date?></strong></small></h4>
				</div>
				<div class='col-sm-1'> </div>
			</div>
			<div class='row'>
				<div class='col-sm-1'> </div>
				<div class='col-sm-10'>
					<h3><p><?php echo $content?></p></h3>
				</div>
				<div class='col-sm-1'> </div>
			</div>
			<?php
				if($user_id == $userown_id){
					echo"
					<a href='post.php?do=delete&post_id=$post_id' style='float:right;'><button class='btn btn-danger'>Delete</button></a>
					<a href='post.php?do=edit&post_id=$post_id' style='float:right;margin-right:2px;'><button  class='btn btn-info'>Edit</button></a>
					<a href='postDetails.php?post_id=$post_id' style='float:right;margin-right:2px;'><button class='btn btn-success'>View</button></a>
					";
				} 	
			?>

		</div><br>
		<?php } ?>			
	</div>
</div>
<!--End Displaying Users own Posts-->
<?php }else{
	    echo "<script>alert('There Is No ID Exist !')</script>";
        echo "<script>window.open('home.php','_self')</script>";
} ?>
<?php } ?>

<?php
	include 'includes/templates/footer.php';				
?>