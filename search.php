<?php
	session_start();
	$noNavbar = '';
	if(!isset($_SESSION['user_email'])){
		header("location: index.php");
	}else{ 
		include("initialize.php");
?>
<?php include("includes/templates/slidbar.php"); ?>

<div class="container">
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
			<center><h2>See Your reslts here!</h2></center><br><br>
	<?php 
			if(isset($_GET['search'])){
				$search_query = htmlentities($_GET['user_query']);
			}
			$get_posts = $con->prepare("SELECT * from posts where post_content like '%$search_query%'");
			$get_posts ->execute();
			$posts = $get_posts ->fetchAll();
			$count = $get_posts ->rowCount();
			if($count == 0 ){
				echo "<center><h2>There's No Posts To Show,Try Again!</h2></center><br><br>";
			}else{	
			foreach ($posts as $key => $row_posts) {

				$post_id = $row_posts['post_id'];
				$user_id = $row_posts['user_id'];
				$content = substr($row_posts['post_content'],0,40);
				$post_date = $row_posts['post_date'];

				//getting the user who has posted the thread
				$user = $con->prepare("SELECT * from users where user_id='$user_id' AND posts='yes'");
				$user ->execute();
				$row_user = $user ->fetch();
				$user_name = $row_user['user_name'];
				$first_name = $row_user['f_name'];
				$last_name = $row_user['l_name'];
				$user_image = $row_user['user_image'];
				$user_type = $row_user['GroupID'];
	?>
		<!-- Start Post Body -->
			<div class="post">
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
			</div><br>
		<!-- End Post Body -->
	<!-- End Display Posts -->
	<?php }} ?>
	</div>
	</div>
</div>
</div>
<?php } ?>
<?php
	include 'includes/templates/footer.php';
?>
