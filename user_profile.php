<?php
session_start();
$pageTitle = "Profile" ;
$noNavbar = ''; 
include("initialize.php");

if(!isset($_SESSION['user_email'])){
	header("location: index.php");
}else{ 
?>
	<?php
	if(isset($_GET['u_id'])){

		$user_id = $_GET['u_id'];
		$select  = $con->prepare("SELECT * from users where user_id='$user_id'");
		$select  ->execute();
		$row = $select  ->fetch();	

		$id = $row['user_id'];
		$user_image = $row['user_image'];
		$name = $row['user_name'];
		$f_name = $row['f_name'];
		$l_name = $row['l_name'];
		$describe_user = $row['describe_user'];
		$gender = $row['user_gender'];
		$register_date = $row['user_reg_date'];
		$user_country = $row['user_country'];
		$Relationship_status = $row['Relationship'];
		$user_birthday = $row['user_birthday'];

		$share_post = "postDetails.php?post_id=";
	?>	
<div class="container">
<div class='row'>
<center>

	<!-- Start User Information -->
	<div class='col-sm-4' style='background-color: #e6e6e6;'>
	<h2>About</h2>
	<!-- Start profile Image -->
 	<div class='profile_image'>
        <img 
        	src='includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.jpg'; } ?>'
        	alt='Profile' 
        	class='img-circle' 
        	width='180px' 
        	height='180px' 
        />
    <!-- Start Update Image Buttom -->
    <?php if($user_id == $sessionuser_id){ ?>					
	    <form action='user_profile.php?u_id=<?php echo $user_id ?>' method='post' enctype='multipart/form-data'>
			<ul class='nav pull-left' style='position: absolute; top: 240px;left: 30%'>
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
      	</form><br>
	<?php }?>
    <?php 	
        if(isset($_POST['update'])){
		    $u_image = $_FILES['u_image']['name'];
		    $image_tmp = $_FILES['u_image']['tmp_name'];
		    $random_number = rand(1,100);
     	    if($u_image==''){
        	    echo "<script>alert('Please Select Profile Image on clicking on the profile image area!')</script>";
            	echo "<script>window.open('user_profile.php?u_id=$user_id','_self')</script>";
           		exit();
          	}else{  
              	move_uploaded_file($image_tmp,"includes/images/users/$u_image.$random_number");
			  	$update = $con->prepare("UPDATE users SET user_image = '$u_image.$random_number' WHERE user_id = $user_id ");
			  	$update ->execute();  
	            if($update){
	            	echo "<script>alert('Your Profile Updated!')</script>";
	              	echo "<script>window.open('user_profile.php?u_id=$user_id','_self')</script>";
	            }
            }
        }
    ?>  
    <!-- End Update Image Buttom -->       	
    </div><br>
    <!-- End profile Image -->
	<ul class='list-group'>
	  <li class='list-group-item' title='Username'><strong>Name : <?php echo $f_name.' '.$l_name ?></strong></li>
	  <li class='list-group-item' title='Bio'>Bio : <?php echo  $describe_user?></li>
	  <li class='list-group-item' title='Gender'>Gende : <?php echo  $gender?></li>
	  <li class='list-group-item' title='Country'>Country : <?php echo  $user_country?></li>
	  <li class='list-group-item' title='Re_Status'>Relation Status : <?php echo  $Relationship_status?></li>
	  <li class='list-group-item' title='Birth_date'>Birth Date : <?php echo  $user_birthday?></li>
	  <li class='list-group-item' title='Registration Date'>Since : <?php echo  $register_date?></li>
	</ul>
	<?php		
	if($user_id == $sessionuser_id){
		echo"<a href='edit_profile.php?u_id=$sessionuser_id' class='btn btn-success'/>Edit Profile</a><br><br><br>";
	}
	?>		
</center>
<!-- End User Information -->



	<!-- Start Displaying Users own Posts-->
	<div class="col-sm-8">
	<?php
	if($user_id == $sessionuser_id){
		echo "<center><h1><strong>Your Posts</strong></h1></center>";
	}else{
		echo "<center><h1><strong>$name Posts</strong></h1></center>";
	}	
	?>	
		<?php
			global $con;
			if(isset($_GET['u_id'])){
			$u_id = $_GET['u_id'];
			}

			$get_posts = $con->prepare("SELECT * from posts where user_id='$u_id' And postType = 1 ORDER by 1 Desc ");
			$get_posts ->execute();
			$posts = $get_posts ->fetchAll();	
			
			foreach ($posts as $key => $row_posts){

				$post_id = $row_posts['post_id'];
				$user_id = $row_posts['user_id'];
				$content = $row_posts['post_content'];
				$post_date = $row_posts['post_date'];
			
				//getting the user who has posted the thread
				$get_user = $con->prepare("SELECT * from users where user_id='$user_id' AND posts='yes'");
				$get_user ->execute();
				$user = $get_user ->fetch();				
				$user_name = $user['user_name'];
				//now displaying all at once 
		?>
<!-- Start Post Body -->
		<div class='row'>
			<div class='col-sm-1'> </div>
			<div class='col-sm-11 post'>
				<!-- Start Post's User Info  -->
				<div class='row'>
					<div class='col-sm-10 user'>
						<img src='includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.png'; } ?>'>
						<?php				
							if($user_type == 1 ){
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
					<a href='postDetails.php?post_id=<?php echo $post_id ?>' class='show-btn btn btn-info'>Show Comment</a>	
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
			<!-- <div class='col-sm-1'> </div> -->
		</div><br>
		<!-- End Post Body -->				
		<?php } ?>			
	</div>
</div>	
</div>

	<?php } ?>
<?php } ?>
<?php
	include 'includes/templates/footer.php';				
?>
