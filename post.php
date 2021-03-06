<?php
session_start();
$pageTitle = "Post";
$noNavbar = '';
if(!isset($_SESSION['user_email'])){
 header("location: index.php");
}else{   
  	include 'initialize.php';		
	$do = isset($_GET['do']) ? $_GET['do'] : "manage";
	
	// Start Manage Page
	if ($do == 'manage'){ 

		echo 'WELCOME';

	}elseif ( $do == 'insert') {

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
			$content 	  = htmlentities($_POST['content']);
			$likes     	  = 0;
			$postshare    = 0;
			$posttype     = $_POST['posttype'];
			$status       = 0;
			$AllowComment = 0;
			$catid        = $_POST['category'];
			$userid       = $_POST['userid'];

	        if(strlen($content) > 500){
	        	echo "<script>alert('Please Use 450 or less than 450 words')</script>";
	        	echo"<script>window.open('home.php','_self')</script>";
		    }else{
	            if(strlen($content) > 0){

		            $stmt = $con->prepare("
						INSERT INTO posts(post_content,post_date,likes,postShare,postType,status,AllowComment,Cat_id,user_id)
						VALUES(:zpost,now(),:zlike,:zshare,:ztype,:zstatus,:zallowcom,:zcatid,:zuserid ) ") ;
					$stmt->execute(array(
						'zpost'    	=> $content,
						'zlike'     => $likes,
						'zshare'    => $postshare,
						'ztype'    	=> $posttype,
						'zstatus'   => $status,
						'zallowcom' => $AllowComment,
						'zcatid'    => $catid,
						'zuserid'   => $userid					
					));
					if($stmt){
						echo "<script>alert('Your Post Have Been Updated Successfully.')</script>";
						echo"<script>window.open('home.php','_self')</script>";
						$update = $con->prepare("UPDATE users SET posts = 'yes' WHERE user_id = ? ");
						$update->execute(array($userid));
					}else{
						echo "<script>alert('There are Error !!')</script>";
						echo"<script>window.open('home.php','_self')</script>";
					}
					exit();
				}
			} 
		}	  

	}elseif($do == 'edit'){
	?>	
	<div class="row">
		<div class="col-sm-3"> </div>
		<div class="col-sm-6">
		<?php
			if(isset($_GET['post_id'])){

				$get_id = $_GET['post_id'];
				$get_post = $con->prepare("SELECT * from posts where post_id='$get_id'");
				$get_post ->execute();
				$row = $get_post ->fetch();	
				$post_con = $row['post_content'];

			}
		?>
			<form action="" method="post" id="f"><br>

				<center><h2>Edit Your Post:</h2></center><br>
				<textarea class="form-control" cols="83" rows="4" name="content"><?php echo $post_con;?></textarea><br>
				<input type="submit" name="update" value="Update Post" class="btn btn-info"/>

			</form>

		<?php
				if(isset($_POST['update'])){

					$content = $_POST['content'];
					$update_post = $con->prepare("UPDATE posts set post_content='$content' where post_id='$get_id'");
					$update_post ->execute();

					if($update_post){
						echo "<script>alert('Post has been updated!')</script>";
						echo "<script>window.open('home.php','_self')</script>";
					}
				}
		?>
		</div>
		<div class="col-sm-3"> </div>
	</div>
	<?php
	}elseif($do == 'delete'){

		$post_id = isset($_GET['post_id']) && is_numeric($_GET['post_id']) ? intval($_GET['post_id']) : 0 ;
		$stmt = $con->prepare("SELECT * FROM posts WHERE post_id = ? ");
		$stmt->execute(array($post_id));
		$row = $stmt->fetch();
		$count = $stmt->rowCount(); 

		if($count > 0 )
		{

			$stmt = $con->prepare("DELETE FROM posts WHERE post_id = :zpostid") ;
			$stmt->bindParam(":zpostid", $post_id); 
			$stmt->execute(); 
			if($stmt){
				echo "<script>alert('A post has been deleted!')</script>";
				echo "<script>window.open('home.php','_self')</script>";
			}

		}else{
			echo "<script>alert('This ID Is Not  Exist')</script>";
			echo "<script>window.open('home.php','_self')</script>";
		}
	}elseif($do == 'private'){
			
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$doc_id 	  = $_POST['doc_id'];
			$content 	  = htmlentities($_POST['content']);
			$likes     	  = 0;
			$postshare    = 0;
			$posttype     = 3;
			$status       = 0;
			$AllowComment = 0;
			$catid        = 0;
			$userid       = $sessionuser_id;

	        if(strlen($content) > 500){
	        	echo "<script>alert('Please Use 450 or less than 450 words')</script>";
	        	echo"<script>window.open('home.php','_self')</script>";
		    }else{
	            if(strlen($content) >= 0){

		            $stmt = $con->prepare("
						INSERT INTO posts(post_content,post_date,likes,postShare,postType,privateTo,status,AllowComment,Cat_id,user_id)
						VALUES(:zpost,now(),:zlike,:zshare,:ztype,:zprivateTo,:zstatus,:zallowcom,:zcatid,:zuserid ) ") ;
					$stmt->execute(array(
						'zpost'    	=> $content,
						'zlike'     => $likes,
						'zshare'    => $postshare,
						'ztype'    	=> $posttype,
						'zprivateTo'=> $doc_id,
						'zstatus'   => $status,
						'zallowcom' => $AllowComment,
						'zcatid'    => $catid,
						'zuserid'   => $userid					
					));
					if($stmt){
						echo "<script>alert('Your Post Have Been Updated Successfully.')</script>";
						echo"<script>window.open('home.php','_self')</script>";
						$update = $con->prepare("UPDATE users SET posts = 'yes' WHERE user_id = ? ");
						$update->execute(array($userid));
					}else{
						echo "<script>alert('There are Error !!')</script>";
						echo"<script>window.open('home.php','_self')</script>";
					}
					exit();
				}
			} 
		}	
			echo "<script>alert('<?php echo $doc_id?>')</script>";
	}elseif($do == 'postDetails'){
	?>
	<?php include("includes/templates/slidbar.php"); ?>
<div class="container">
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-11">
			<center><h2>Comments</h2><br></center>
<?php 

if(isset($_GET['post_id'])){

		$get_id = $_GET['post_id'];
		$get_posts = $con->prepare("SELECT * from posts where post_id='$get_id'");
		$get_posts ->execute();
		$row_posts = $get_posts ->fetch();	
		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$content = $row_posts['post_content'];
		$post_date = $row_posts['post_date'];
		$privateto = $row_posts['privateTo'];
		$website = "http://localhost/GP/Behman%20V2.1/post.php?do=postDetails&post_id=";

		//getting the user who has posted the thread
		$user = $con->prepare("SELECT * from users where user_id='$user_id' AND posts='yes'");
		$user ->execute();
		$row_user = $user ->fetch();	
		$user_name = $row_user['user_name'];
		$user_image = $row_user['user_image'];
		$user_type= $row_user['GroupID'];

		// getting the user session
		$user_com = $_SESSION['user_email'];
		$get_com = $con->prepare("SELECT * from users where user_email='$user_com'");
		$get_com ->execute();
		$row_com = $get_com ->fetch();
		$user_com_id = $row_com['user_id'];
		$user_com_name = $row_com['user_name'];

		//now displaying all at once
		if(isset($_GET['post_id'])){ $post_id = $_GET['post_id']; }
		$post_id = $_GET['post_id'];
		$post = $_GET['post_id'];
		$get_user = $con->prepare("SELECT * from posts where post_id='$post'");
		$get_user ->execute();
		$row = $get_user ->fetch();
		$p_id = $row['post_id'];
		$postType = $row['postType'];
		$post_user = $row['user_id'];

		if($p_id != $post_id){
			echo "<script>alert('ERROR')</script>";
			echo "<script>window.open('home.php','_self')</script>";
		}else{
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
					<a href='post.php?do=postDetails&post_id=<?php echo $post_id ?>' class='show-btn btn btn-info'>Comment</a>	
					<div class="share-area">
					  <div id="popover-div" class="col-sm-12 col-xs-12 col-md-9" >
					    <a id="share" class="btn btn-info change-trigger" data-original-title="Share a link to this post">Share</a>        
					    <div class="hide" id="html-div">
					      <form class="share-form" style="height:70px;">
					        <div class="form-group" style="display:inline-flex;">
					          <input class="form-control share-link" id="post_link" type="text" readonly=""  value="<?php echo $website.$post_id ?>"/>
					          <a onclick="myFunction()" id="copy" class="share-copy-button btn btn-info" style="margin-top:10px;margin-left:3px;padding-bottom:5px;">Copy</a>
					        </div>

					<div style="margin-top:-16px;display:inline-flex;">
					    <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $website.$post_id ?>" data-text="Behman is an amazing website, very recommended to you my friends." data-size="large">Tweet</a>
						 <a class="fb-share-button" data-href="http://fcih.helwan.edu.eg/" data-type="button_count" data-size="large" style="margin-left: 5px;"></a>
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

		<!-- Start Comment Body -->
		<?php	
			$get_id = $_GET['post_id'];
			$get_com = $con->prepare("SELECT  * from comments where post_id='$get_id' ORDER by 1 DESC ");
			$get_com ->execute();
			$comments = $get_com ->fetchAll();
	
			$get_type = $con->prepare("SELECT * from users where user_id='$sessionuser_id'");
			$get_type ->execute();
			$type = $get_type ->fetch();
			$Type = $type['GroupID'];

			foreach ($comments as $key => $comment){
				$com = $comment['comment']; 
				$com_name = $comment['comment_author']; 
				$date = $comment['date']; 
				echo "
				<div class='row'>
					<div class='col-sm-2'> </div>
			        <div class='col-sm-8 Displayed-comment'>
			            <div class='panel panel-info'>
			                <div class='panel-body'>
								<h4><strong>$com_name</strong><i> commented</i> on $date</h4>
								<p class='comment'>$com</p> 
			                </div>
			            </div>
			        </div>
		        </div>
				";
				}if (( $Type == 2 && $postType == 2 ) || $sessionuser_id == $post_user){
				echo "
				<div class='row'>
					<div class='col-sm-2'></div>
			        <div class='col-md-8'>
			            <div class='panel panel-info send-panel'>
			                <div class='form-group panel-body'>
			                	<form action='' method='post'>
			                			<textarea class='form-control' rows='4' name='comment' placeholder='Write your comment here!''></textarea>
			                    		<button class='btn btn-info pull-right send-btn' name='reply'>
			                    		<i class='fa fa-paper-plane' aria-hidden='true'></i> Comment</button>
			                    </form>
			                </div>
			            </div>
			        </div>
		        </div>
				";
			    }elseif($postType == 1){
				echo "
				<div class='row'>
					<div class='col-sm-2'></div>
			        <div class='col-md-8'>
			            <div class='panel panel-info send-panel'>
			                <div class='form-group panel-body'>
			                	<form action='' method='post'>
			                			<textarea class='form-control' rows='4' name='comment' placeholder='Write your comment here!''></textarea>
			                    		<button class='btn btn-info pull-right send-btn' name='reply'>
			                    		<i class='fa fa-paper-plane' aria-hidden='true'></i> Comment</button>
			                    </form>
			                </div>
			            </div>
			        </div>
		        </div>
				";			    	
			    }elseif ($privateto == $user_com_id){
				echo "
				<div class='row'>
					<div class='col-sm-2'></div>
			        <div class='col-md-8'>
			            <div class='panel panel-info send-panel'>
			                <div class='form-group panel-body'>
			                	<form action='' method='post'>
			                			<textarea class='form-control' rows='4' name='comment' placeholder='Write your comment here!''></textarea>
			                    		<button class='btn btn-info pull-right send-btn' name='reply'>
			                    		<i class='fa fa-paper-plane' aria-hidden='true'></i> Comment</button>
			                    </form>
			                </div>
			            </div>
			        </div>
		        </div>
				";}
			if(isset($_POST['reply'])){
				$comment = htmlentities($_POST['comment']);
					if($comment == ""){
					echo"<script>alert('Enter your comment!')</script>";
					echo "<script>window.open('post.php?do=postDetails&post_id=$post_id','_self')</script>";
					}else{
					$insert = $con->prepare("
						INSERT into comments 
						(post_id,user_id,comment,comment_author,date) 
						values 
						('$post_id','$user_id','$comment','$user_com_name',NOW())");
					$insert ->execute();
					echo"<script>alert('Your Reply was added!')</script>";
					echo "<script>window.open('post.php?do=postDetails&post_id=$post_id','_self')</script>";
				}
			}
		}
		/* End Comment Body */
	}
	?>			
		</div>
	</div>
</div>

<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
<script>
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
</script>

	<?php
	}
}	
?>
<?php
	include 'includes/templates/footer.php';
?>