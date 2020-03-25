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

	<!-- Start Create Post -->
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8 insert-post">
			<h4> Create Post :</h4>
		  	<form action="post.php?do=insert" method="POST" enctype='multipart/form-data'>
		  		<div class="row">
					<input type="hidden" name="userid" value="<?php echo $user_id?>"/>
					<div class="col-sm-10">
						<textarea class="form-control" rows="4" name="content" placeholder="What's in your Mind ?"></textarea>
					</div>
					<!--Start Status Field-->
					<div class="form-group col-sm-2 select-type"> 
						<label class="control-label type-lable">To: </label>		
						<select class="form-control" name="posttype">
							<option value="0">...</option>		
							<option value="1">puplic</option>
							<option value="2">Only Doctor</option>
							<option value="3">Private Doctor</option>				
						</select>
					</div>
				<!--End Status Field-->
				</div><br/>
				<button type="sbumit" id="btn-post" class="btn">Post</button>
			</form>
		</div>
		<div class="col-sm-2"></div>
	</div>
	<!-- End Create Post -->

	<div class="row">
		<div class="col-sm-12">
			<center><h2><strong>News Feed</strong></h2><br></center>
	<?php
	global $con;
	$per_page=4;
	if (isset($_GET['page'])) {
	$page = $_GET['page'];
	}
	else {
	$page=1;
	}
	$start_from = ($page-1) * $per_page;

	$select_posts = $con->prepare("SELECT * FROM posts ORDER by 1 DESC LIMIT $start_from, $per_page");
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
   <?php
	}
	/* Start Pagination Area */ 
	$stmt = $con->prepare("SELECT * FROM posts");
	$stmt ->execute();
	$posts = $stmt ->fetchAll();
	$total_pages = $stmt ->rowcount();

	//Using ceil function to divide the total records on per page
	$total_pages = ceil($total_pages / $per_page);
	
	//Going to first page
	echo "
	<center>
	<div class='pagination'>
	<a href='home.php?page=1'>First Page</a>
	";
	
	for ($i=1; $i<=$total_pages; $i++) {
	echo "<a href='home.php?page=$i'>$i</a>";
	}
	// Going to last page
	echo "<a href='home.php?page=$total_pages'>Last Page</a></center></div>";
	/* End Pagination Area */ 
	?>
		</div>
	</div>
</div>

<?php } ?>

<?php
	include 'includes/templates/footer.php';
?>

