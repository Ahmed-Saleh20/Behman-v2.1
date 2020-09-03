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
		$user_birthday = $row['user_birthday'];

		$share_post = "postDetails.php?post_id=";
	?>	
<div class="container">
<div class='row'>
<center>

	<!-- Start User Information -->

	<div class='col-sm-4' style='background-color: #eee;'>
	<h2>ABOUT</h2>
	<!-- Start profile Image -->
 	<div class='profile_image'>
        <img 
        	src='includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.jpg'; } ?>'
        	alt='Profile' 
        	class='img-circle user-img-user' 
        	width='180px' 
        	height='180px' 
        />
    <!-- Start Update Image Buttom -->
    <?php if($user_id == $sessionuser_id){ ?>					
	    <form action='user_profile.php?u_id=<?php echo $user_id ?>' method='post' enctype='multipart/form-data'>
			<ul class='nav pull-left update-btn'>
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
	  <li class='list-group-item' title='Birth_date'>Birth Date : <?php echo  $user_birthday?></li>
	  <li class='list-group-item' title='Registration Date'>Since : <?php echo  $register_date?></li>
	</ul>
	<?php		
	if($user_id == $sessionuser_id){
		echo"<a href='edit_profile.php?u_id=$sessionuser_id' class='btn btn-info'/>Edit Profile</a><br><br><br>";
	}
	?>		
</center>
<!-- End User Information -->


<div class="col-sm-8">
	<!-- nav-pills for private chats and posts -->		
	<?php if($user_id == $sessionuser_id){ ?>
	<center>
	  <ul id="my_pills" class="nav nav-pills"
	  	style="font-size:20px;border-color:#DDD;background-color:#eee;margin-top:0;max-width: 203px;padding-left: 5px;padding-right: 5px;border-radius: 10px">
	 	<li class="active"><a data-toggle="pill" href="#posts">Posts</a></li>
	    <li><a data-toggle="pill" href="#private">Privat Chats</a></li>
	  </ul>
	</center>
	<?php } ?>	
	<!-- nav-pills for private chats and posts -->


<div class="tab-content">
	<div id="posts" class="tab-pane fade in active">
		<center><h1><strong>Posts</strong></h1><br></center>

		<?php
			global $con;
			if(isset($_GET['u_id'])){
			$u_id = $_GET['u_id'];
			}

			$get_posts = $con->prepare("SELECT * from posts where user_id='$u_id' ORDER by 1 Desc ");
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
					<a href='post.php?do=postDetails&post_id=<?php echo $post_id ?>' class='show-btn btn btn-info'>Show Comment</a>	
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

    <div id="private" class="tab-pane fade">
		<center><h1><strong>Booked Chat</strong></h1><br></center>
		<!-- get private chats -->
		  	<?php 
				$private = $con->prepare("SELECT * from coming_private_chat where user_id='$u_id' ORDER by 1 Desc ");
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
					
					$i = $count;
					$name = $row['user_name'];
					$doc_f_name = $row['f_name'];
					$doc_l_name = $row['l_name'];
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

</div>

</div>	
</div>

	<?php } ?>
<?php } ?>
<?php
	include 'includes/templates/footer.php';				
?>
