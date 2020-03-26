<?php
session_start();
$pageTitle = "Home" ;
$noNavbar = ''; 
include("initialize.php");

if(!isset($_SESSION['user_email'])){
	header("location:index.php");
}else{ 

?>
<head>
	<link rel="stylesheet" href="layout/css/font-awesome4.min.css" />
</head>
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
			$user_type = $row_user['type'];

			$share_post = "postDetails.php?post_id=";

		?>

		<!-- Start Display Posts -->
		<div class='row'>
			<div class='col-sm-2'> </div>
			<div id='posts' class='col-sm-8'>
				<div class='row'>
					<div class='col-sm-2'>
						<p><img src='includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.png'; } ?>' class='img-circle' width='100px' height='100px'></p>
					</div>
					<div class='col-sm-6'>
					<?php				
						if($user_type == 1 ){
				    	echo "<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='doc_profile.php?u_id=$user_id'>$user_name</a></h3>";
				    	}else{
				    	echo "<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>";
				    	}
					?>	
				  	<h4><small style='color:black;'>Updated a post on <strong><?php echo $post_date ?></strong></small></h4>
					</div>
					<div class='col-sm-4'> </div>
				</div>
				
				<div class='row'>
					<div class='col-sm-2'> </div>
					<div class='col-sm-6'>
						<h3><p><?php echo $content ?></p></h3>
					</div>
					<div class='col-sm-4'> </div>
				</div>
				<a href='postDetails.php?post_id=<?php echo $post_id ?>' style='float:right;'><button class='btn btn-info'>Comment</button></a>
				
				<div class="share-area">
				  <div id="popover-div" class="col-sm-12 col-xs-12 col-md-9">
				    <buttom id="share" class="btn btn-info change-trigger" data-original-title="Share a link to this post">Share</buttom>        
				    <div class="hide" id="html-div">
				      <form class="share-form">
				        <div class="form-group">
				          <input class="form-control share-link" id="post_link" type="text" readonly=""  value="<?php echo $share_post.$post_id ?>"/>
				        </div>
				        <div class="form-group">
				        <a onclick="myFunction()" id="copy" class="share-copy-button">Copy link</a>
 				        </div>
				      </form>
				    </div>
				  </div>
				</div>
 				<div class="post-info">
				    <!-- if user likes post, style button differently -->
			      	<i <?php if (userLiked($post_id) ){?>
			      		  class="fa fa-thumbs-up fa-7x like-btn"
			      	  <?php }else{ ?>
			      		  class="fa fa-thumbs-o-up fa-7x like-btn"
			      	  <?php } ?>
			      	  data-id="<?php echo $post_id; ?>"></i>
			      	<span class="likes"><?php echo getLikes($post_id); ?></span>
				</div>
			    <script src="layout/js/scripts.js"></script>
			</div>
			<div class='col-sm-3'> </div>
		</div><br>
		<!-- End Display Posts -->
   <?php } ?>
		</div>
	</div>
</div>

<?php } ?>

<?php
	include 'includes/templates/footer.php';
?>

