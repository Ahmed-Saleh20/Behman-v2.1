
<?php
 
include 'connectDB.php';


function getTitle(){

	global $pageTitle ;

	if (isset($pageTitle)){  // IF The Page Include Variable Named '$pageTitle' Make it The Title Of Page

		echo $pageTitle;
	}else{

		echo 'Default Title';
	}
}

/* Start Like Functions */

// if user clicks like or dislike button
if (isset($_POST['action'])) {

	$useremail = $_SESSION['user_email'];
	$select_user = $con->prepare("SELECT * FROM users WHERE user_email= ?");
	$select_user ->execute(array($useremail));
	$row = $select_user ->fetch();			
	$user_id = $row['user_id']; 


	$post_id = $_POST['post_id'];
  	$action = $_POST['action'];

	  switch ($action) {
	  	case 'like':
	        $sql = $con->prepare("INSERT INTO 
	                                    rating_info (user_id, post_id, rating_action) 
	                                VALUES 
	                                    ($user_id, $post_id, 'like') 
	                                ON 
	                                    DUPLICATE KEY 
	                                UPDATE 
	                                    rating_action='like'");
	    break;

	  	case 'unlike':
	        $sql = $con->prepare("DELETE FROM 
	                                    rating_info 
	                                WHERE 
	                                    user_id=$user_id 
	                                AND 
	                                    post_id=$post_id");
		  break;

	  	default:
	  	break;
	  }

  // execute query to effect changes in the database ...
  $sql ->execute();
  echo getRating($post_id);
  exit(0);
}

// Get total number of likes for a particular post
function getLikes($id)
{
	global $con;
	$sql = $con->prepare("SELECT COUNT(*) FROM rating_info WHERE post_id = $id AND rating_action='like'");
	$sql ->execute();
	$result = $sql ->fetch();
	$total = $result[0];
	$sql2 = $con->prepare("UPDATE posts SET likes=$total WHERE post_id = $id");
	$sql2 ->execute();
	return $result[0];

} 

// Get total number of likes and dislikes for a particular post
function getRating($id)
{
	global $con;
	$rating = array();
	$likes_query = $con->prepare("SELECT COUNT(*) FROM rating_info WHERE post_id = $id AND rating_action='like'");
	$likes_query ->execute();
	$likes = $likes_query ->fetch();
	$rating = [
	   'likes' => $likes[0],
	];
	return json_encode($rating);
}

// Check if user already likes post or not
function userLiked($post_id)
{
  	global $con;
  	
  	$useremail = $_SESSION['user_email'];
	$select_user = $con->prepare("SELECT * FROM users WHERE user_email= ?");
	$select_user ->execute(array($useremail));
	$row = $select_user ->fetch();			
	$user_id = $row['user_id']; 

  	$sql = $con->prepare("SELECT * FROM rating_info WHERE user_id=$user_id AND post_id=$post_id AND rating_action='like'");
  	$sql ->execute();
  	$count = $sql->rowCount();

  	if ($count > 0) {
  		return true;
  	}else{
  		return false;
  	}
}

/* End Like Functions */

/*
** Display Details of Post v1.0
** 
**
*/

function single_post(){

	if(isset($_GET['post_id'])){

		global $con;
		$get_id = $_GET['post_id'];
		$get_posts = $con->prepare("SELECT * from posts where post_id='$get_id'");
		$get_posts ->execute();
		$row_posts = $get_posts ->fetch();	
		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$content = $row_posts['post_content'];
		$post_date = $row_posts['post_date'];

		//getting the user who has posted the thread
		$user = $con->prepare("SELECT * from users where user_id='$user_id' AND posts='yes'");
		$user ->execute();
		$row_user = $user ->fetch();	
		$user_name = $row_user['user_name'];
		$user_image = $row_user['user_image'];
		$user_type= $row_user['type'];

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

		if($p_id != $post_id){
			echo "<script>alert('ERROR')</script>";
			echo "<script>window.open('home.php','_self')</script>";
		}else{
		?>	
			<!-- Start Display Posts -->
			<div class='row'>
				<div class='col-sm-3'> </div>
				<div id='posts' class='col-sm-6'>
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
		<?php	
			$get_id = $_GET['post_id'];
			$get_com = $con->prepare("SELECT  * from comments where post_id='$get_id' ORDER by 1 DESC ");
			$get_com ->execute();
			$comments = $get_com ->fetchAll();
	
			foreach ($comments as $key => $comment){
			
				$com = $comment['comment']; 
				$com_name = $comment['comment_author']; 
				$date = $comment['date']; 
				echo "

				<div class='row'>
		        <div class='col-md-6 col-md-offset-3'>
		            <div class='panel panel-info'>
		                <div class='panel-body'>
		                	<div>
							<h4><strong>$com_name</strong><i> commented</i> on $date</h4>
							<p class='text-primary' style='margin-left:5px;font-size:20px;'>$com</p>
							</div> 
		                </div>
		            </div>
		        </div>
		        </div>
				";
			}
			echo "
			<div class='row'>
	        <div class='col-md-6 col-md-offset-3'>
	            <div class='panel panel-info'>
	                <div class='panel-body'>
	                	<form action='' method='post' class='form-inline'>
	                    <textarea placeholder='Write your comment here!'' class='pb-cmnt-textarea' name='comment'></textarea>
	                    <button class='btn btn-info pull-right' name='reply'>Comment</button>
	                    </form>
	                </div>
	            </div>
	        </div>
	        </div>
			";
			if(isset($_POST['reply'])){

				$comment = htmlentities($_POST['comment']);
				if($comment == ""){
				echo"<script>alert('Enter your comment!')</script>";
				echo "<script>window.open('postDetails.php?post_id=$post_id','_self')</script>";
				}else{
				$insert = $con->prepare("INSERT into comments (post_id,user_id,comment,comment_author,date) values ('$post_id','$user_id','$comment','$user_com_name',NOW())");
				$insert ->execute();
				echo"<script>alert('Your Reply was added!')</script>";
				echo "<script>window.open('postDetails.php?post_id=$post_id','_self')</script>";
				}
			}
		}
	}
}


function search_user(){

	global $con;
	if(isset($_GET['search_user_btn'])){
	$search_query = htmlentities($_GET['search_user']);

	$get_user = 
	$con->prepare("SELECT * from users where f_name like '%$search_query%' OR l_name like '%$search_query%' OR user_name like '%$search_query%'");

	}else{
	$get_user = $con->prepare("SELECT * from users ");
	}

	$get_user ->execute();
	$rows = $get_user ->fetchAll();	

	foreach ($rows as $key => $row_user){
		$user_id = $row_user['user_id'];
		$f_name = $row_user['f_name'];
		$l_name = $row_user['l_name'];
		$username = $row_user['user_name'];
		$user_image = $row_user['user_image'];
		$user_type = $row_user['type'];
		//now displaying all at once
		echo "
		<div class='row'>
			<div class='col-sm-3'> </div>
			<div class='col-sm-6'>
			<div class='row' id='find_people'>
			<div class='col-sm-4'>
			<a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>
			<img class='img-circle' src='includes/images/users/$user_image' width='150px' height='140px' title='$username' style='float:left; margin:1px;'/>
			</a>
			</div><br><br>
			<div class='col-sm-6'>
			";
		?>
		<?php				
			if($user_type == 1 ){
	    	echo "<a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='doc_profile.php?u_id=$user_id'>
			<strong><h2>$f_name $l_name</h2></strong>
			</a>";
	    	}else{
	    	echo "<a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>
			<strong><h2>$f_name $l_name</h2></strong>
			</a>";
	    	}
		?>	
		<?php
		echo "
			</div>
			<div class='col-sm-3'> </div>
			</div>
			</div>
			<div class='col-sm-4'> </div>
		</div><br>
		";

	}

}
function insert_user(){
	if(isset($_POST['sign_up'])){

		$first_name = htmlentities($_POST['first_name']);
		$last_name = htmlentities($_POST['last_name']);
		$pass = htmlentities($_POST['u_pass']);
		$email = htmlentities($_POST['u_email']);
		$country = htmlentities($_POST['u_country']);
		$gender = htmlentities($_POST['u_gender']);
		$birthday = htmlentities($_POST['u_birthday']);
		$status = "verified";
		$posts = "no";
		$newgid = sprintf('%05d', rand(0, 999999));
		
		$username = strtolower($first_name . "_" . $last_name . "_" . $newgid);

		$check_username_query = $con->prepare("SELECT user_name from users where user_email='$email'");
		$check_username_query ->execute();
		$run_username = $check_username_query ->fetch();	
		
		if(strlen($pass)<8){
			echo "<script>alert('Password should be minimum 8 characters!')</script>";
			exit();
		}

		$check_email = $con->prepare("SELECT user_name from users where user_email='$email'");
		$check_email ->execute();
		$run_username = $check_email ->fetch();
		$check = $check_email->rowCount();

		if($check > 0){
			echo "<script>alert('Email already exist, please try another!')</script>";
			echo "<script>window.open('signup.php','_self')</script>";
			exit();
		}

		$stmt = $con->prepare("INSERT into 
									users 
									(f_name,l_name,user_name,describe_user,Relationship,user_pass,user_email,user_country,user_gender,user_birthday,user_image,user_cover,user_reg_date,status,posts,recovery_account,type)
									values 
									('$first_name','$last_name','$username','Hello!! This is my default status','........','$pass','$email','$country','$gender','$birthday','default.png','default_cover.jpg',NOW(),'$status','$posts','ifyouaregootatsomethingdontdoitforfree45566677888','1')");
		$stmt ->execute();
		$Userdata = $stmt ->fetch();
		$query = $Userdata->rowCount();
		if($query){
			echo "<script>alert('Congratulations $first_name, your account has been created successfully.')</script>";
			echo "<script>window.open('signin.php','_self')</script>";
		}else {
			echo "<script>alert('Registration failed, try again!')</script>";
			echo "<script>window.open('signup.php','_self')</script>";
		}
	}
}	
?>
<?php
	include 'includes/templates/footer.php';
?>
