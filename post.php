<?php
session_start();
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
			$likes     = 0;
			$postshare    = 0;
			$posttype     = $_POST['posttype'];;
			$status       = 0;
			$AllowComment = 0;
			$catid        = 0;
			$userid       = $_POST['userid'];

	        if(strlen($content) > 500){
	        	echo "<script>alert('Please Use 450 or less than 450 words')</script>";
	        	echo"<script>window.open('home.php','_self')</script>";
		    }else{
	            if(strlen($content) >= 0){

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
						echo "<script>window.open('postDetails.php?post_id=$get_id','_self')</script>";
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
	}
}	
?>
<?php
	include 'includes/templates/footer.php';
?>