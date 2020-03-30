<?php

session_start();
$pageTitle = "Home" ;
include("initialize.php");


?>

<center><h2><strong>News Feed</strong></h2><br></center>

<!-- Start Display Posts -->
<?php

	$select_posts = $con->prepare("SELECT * FROM posts ORDER BY post_id Desc ");
	$select_posts ->execute();
	$posts = $select_posts ->fetchAll();

	foreach ($posts as $key => $post){

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
		$user_type = $row_user['type'];

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
					<a href='postDetails.php?post_id=<?php echo $post_id ?>' class='show-btn btn btn-info'>Comment</a>	
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
<!-- End Display Posts -->
<?php
	include 'includes/templates/footer.php';
?>

