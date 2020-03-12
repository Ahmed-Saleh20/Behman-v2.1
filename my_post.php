<?php
session_start();
$pageTitle = "Latest Posts" ;
$noNavbar='';
include("initialize.php");
if(!isset($_SESSION['user_email'])){
	header("location: index.php");
}else{ ?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<center><h2>Your Latest Posts</h2></center>
	<?php			
		global $con;
		$u_id = isset($_GET['u_id']) && is_numeric($_GET['u_id']) ? intval($_GET['u_id']) : 0 ; 
		$stmt = $con->prepare("SELECT * FROM users WHERE user_id = ? ");
		$stmt->execute(array($u_id));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();

		if($count > 0 )
		{

			$get_posts = $con->prepare("SELECT * from posts where user_id='$u_id' ORDER by 1 DESC LIMIT 5");
			$get_posts ->execute();
			$posts = $get_posts ->fetchAll();	

			foreach ($posts as $key => $row_posts) {

				$post_id = $row_posts['post_id'];
				$user_id = $row_posts['user_id'];
				$content = $row_posts['post_content'];
				$post_date = $row_posts['post_date'];

				//getting the user who has posted the thread
				$user = $con->prepare("SELECT* from users where user_id='$user_id' AND posts='yes'");
				$user->execute();
				$row_user = $user ->fetch();	
				$user_name = $row_user['user_name'];

				$get_posts = $con->prepare("SELECT user_email from users where user_id='$u_id'");
				$get_posts->execute();
				$row = $get_posts ->fetch();
				$user_email = $row['user_email'];
				$user = $_SESSION['user_email'];

				$get_user = $con->prepare("SELECT * from users where user_email='$user'");
				$get_user->execute();
				$row = $get_user ->fetch();
				$user_id = $row['user_id'];
				$u_email = $row['user_email'];
				$user_type = $row['type'];

				if($u_email != $user_email){
					echo"<script>window.open('home.php','_self')</script>";
				}else{
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
						<a href='postDetails.php?post_id=<?php echo $post_id ?>' style='float:right;'><button class='btn btn-info'>Comment</button></a><br>
					</div>
					<div class='col-sm-3'> </div>
				</div><br>
				<!-- End Display Posts -->
   <?php
				}
			}
		}else{
		echo"<script>alert('This ID Is Not  Exist')</script>";
		echo"<script>window.open('home.php','_self')</script>";
		}
	?>
		</div>
	</div>
</div>

<?php } ?>
<?php
	include 'includes/templates/footer.php';
?>
