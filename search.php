<?php
	session_start();
	$noNavbar = '';
	if(!isset($_SESSION['user_email'])){
		header("location: index.php");
	}else{ 
		include("initialize.php");
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<center><h2>See Your reslts here!</h2></center><br><br>
	<?php 
			if(isset($_GET['search'])){
			$search_query = htmlentities($_GET['user_query']);
			}

			$get_posts = $con->prepare("SELECT * from posts where post_content like '%$search_query%'");
			$get_posts ->execute();
			$posts = $get_posts ->fetchAll();

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
				$user_type = $row_user['type'];
	?>
				<!-- Start Display Posts -->
				<div class='row'>
					<div class='col-sm-2'> </div>
					<div id='posts' class='col-sm-8'>
						<div class='row'>
							<div class='col-sm-2'>
								<p><img src='includes/images/users/<?php echo $user_image ?>' class='img-circle' width='100px' height='100px'></p>
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
						<a href='postDetails.php?post_id=<?php echo $post_id ?>' style='float:right;'><button class='btn btn-info'>Comment</button></a><br>
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
