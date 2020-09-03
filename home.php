<?php

session_start();
$pageTitle = "Home" ;
$noNavbar = ''; 
include("initialize.php");

if(!isset($_SESSION['user_email'])){
	header("location:index.php");
}else{ 

?>

<?php include("includes/templates/slidbar.php"); ?>

<div class="container">
<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-7">
		<!-- Start Create Post -->	
		<div class="insert-post">
			<h4> Create Post :</h4>
		  	<form action="post.php?do=insert" method="POST" enctype='multipart/form-data'>
		  		<div class="row">
					<input type="hidden" name="userid" value="<?php echo $sessionuser_id?>"/>
					<div class="col-sm-10">
						<textarea id="abstractTextarea" required class="form-control" rows="4" name="content" placeholder="What's in your Mind ?"></textarea>
						<input type="hidden" id="infoMessages" name="category"/>
					</div>
					<!--Start Status Field-->
					<div class="form-group col-sm-2 select-type"> 
						<label class="control-label type-lable">To: </label>		
						<select class="form-control" name="posttype">	
							<option value="1">All</option>
							<option value="2">Only Doctor</option>			
						</select>
					</div>
				<!--End Status Field-->
				</div><br/>
				<button type="sbumit" id="btn-post" class="btn btn-info">Post</button>
			</form>
		</div><hr>
		<!-- End Create Post -->

		<center><h2><strong>News Feed</strong></h2><br></center>
		<!-- Start Display Posts -->
		<?php

		$select_posts = $con->prepare("SELECT * FROM posts Where postType != '3' ORDER BY post_id Desc");
		$select_posts ->execute();
		$posts = $select_posts ->fetchAll();

		foreach ($posts as $key => $post){

			$post_id   = $post['post_id'];
			$user_id   = $post['user_id'];
			$content   = $post['post_content'];
			$post_date = $post['post_date'];
			$post_Cat  = $post['cat_id'];

			//getting the user who has posted the post
			$select_user = $con->prepare("SELECT * FROM users WHERE user_id = ?");
			$select_user ->execute(array($user_id));
			$row_user    = $select_user ->fetch();
			$user_name  = $row_user['user_name'];
			$user_image = $row_user['user_image'];
			$user_type = $row_user['GroupID'];

			$share_post = "postDetails.php?post_id=";
			if ($post_Cat == 0){
		        $cat = "Obscure";
		    }
			if ($post_Cat == 1){
		        $cat = "Children Disorders";
		    }
		    else if ($post_Cat == 2) {
		    	$cat = "Depression";
		    }
		    else if ($post_Cat == 3) {
		    	$cat = "Anxiety Disorders & Obsessions";
		    }
		    else if ($post_Cat == 4) {
		    	$cat = "Relationship Disorders";
		    }
		    else if ($post_Cat == 5) {
		    	$cat = "Learning Disabilities";
		    }
		    else if ($post_Cat == 6) {
		    	$cat = "Addiction";
		    }
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
				<div class="label label-info tags-label"><i class="fa fa-tags" aria-hidden="true"></i> <?php echo $cat?></div>
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

	<!-- Start Best Doctor -->
	<?php
		$select_best = $con->prepare("SELECT user_image,user_name,nComments+nRating AS Total from users Where GroupID = 2 GROUP BY Total DESC LIMIT 5");
		$select_best ->execute();
		$bests = $select_best ->fetchAll();
	?>
	<div class="col-sm-3">
		<div class="bestPanel information">
			<div class="panel panel-info">
				<div class="panel-heading"><span>Best Doctor Of The Week</span></div>
				<img src="includes/images/Best.jpeg" class="panel-img-top" alt="...">
				<div class="panel-body">
					<ul class="list-unstyled">
						<?php foreach ($bests as $key => $best) { 
						$user_image = $best["user_image"];
						?>
						<li class="best-li">
							<img src='includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.png'; } ?>' class="bestDoc-img" alt="...">
							<span><?php echo "<b>Dr</b>.".$best['user_name']?></span>
						</li>	
						<?php }?>										
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- End Best Doctor -->

</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="classifier/js/jquery-2.1.0.min.js"></script>

    <script src="classifier/specializations/depression-111.js"></script>
    <script src="classifier/specializations/childdisorders-111.js"></script>
    <script src="classifier/specializations/anxiety-111.js"></script>
    <script src="classifier/specializations/learning-111.js"></script>
    <script src="classifier/specializations/relationship-111.js"></script>
    <script src="classifier/specializations/addiction-111.js"></script>
    <script src="classifier/src/stopwords.js"></script>

    <script src="classifier/src/sentiment.js"></script>    
    <script src="classifier/src/htmlHelper.js"></script> 
    <script src="classifier/src/abstractFormatting.js"></script>
<?php } ?>
<?php
	include 'includes/templates/footer.php';
?>

