<?php
 
include 'connentDB.php';


	function single_post(){

	if(isset($_GET['post_id'])){

	global $con;

	$get_id = $_GET['post_id'];

	$get_posts = "select * from posts where post_id='$get_id'";

	$run_posts = mysqli_query($con,$get_posts);

	$row_posts=mysqli_fetch_array($run_posts);

		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$content = $row_posts['post_content'];
		$upload_image = $row_posts['upload_image'];
		$post_date = $row_posts['post_date'];

		//getting the user who has posted the thread
		$user = "select * from users where user_id='$user_id' AND posts='yes'";

		$run_user = mysqli_query($con,$user);
		$row_user=mysqli_fetch_array($run_user);

		$user_name = $row_user['user_name'];
		$user_image = $row_user['user_image'];

		// getting the user session
		$user_com = $_SESSION['user_email'];

		$get_com = "select * from users where user_email='$user_com'";
		$run_com = mysqli_query($con,$get_com);
		$row_com=mysqli_fetch_array($run_com);

		$user_com_id = $row_com['user_id'];
		$user_com_name = $row_com['user_name'];


		//now displaying all at once

		if(isset($_GET['post_id'])){
			$post_id = $_GET['post_id'];
			}
			$get_posts = "select post_id from users where post_id='$post_id'";
			$run_user = mysqli_query($con,$get_posts);

			$post_id = $_GET['post_id'];

			$post = $_GET['post_id'];
			$get_user = "select * from posts where post_id='$post'";
			$run_user = mysqli_query($con,$get_user);
			$row=mysqli_fetch_array($run_user);

			$p_id = $row['post_id'];

			if($p_id != $post_id){
				echo "<script>alert('ERROR')</script>";
				echo "<script>window.open('home.php','_self')</script>";
			}else{


		if($content=="No" && strlen($upload_image) >= 1){

			echo "
			<div class='row'>
				<div class='col-sm-3'>
				</div>
				<div id='posts' class='col-sm-6'>
				<div class='row'>
					<div class='col-sm-2'>
						<p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
					</div>
					<div class='col-sm-6'>
						<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
						<h4><small style='color:black;'>Updated a post on <strong>$post_date</strong></small></h4>
					</div>
					<div class='col-sm-4'>

					</div>
				</div>
				<div class='row'>
					<div class='col-sm-12'>
						<img id='posts-img' src='imagepost/$upload_image' style='height:350px;'>
					</div>
				</div><br>
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Comment</button></a><br>
				</div>
				<div class='col-sm-3'>
				</div>
			</div><br><br>
			";

		}
		else if(strlen($content) >= 1 && strlen($upload_image) >= 1){

			echo "
			<div class='row'>
				<div class='col-sm-3'>
				</div>
				<div id='posts' class='col-sm-6'>
				<div class='row'>
					<div class='col-sm-2'>
						<p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
					</div>
					<div class='col-sm-6'>
						<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
						<h4><small style='color:black;'>Updated a post on <strong>$post_date</strong></small></h4>
					</div>
					<div class='col-sm-4'>

					</div>
				</div>
				<div class='row'>
					<div class='col-sm-12'>
						<p>$content</p>
						<img id='posts-img' src='imagepost/$upload_image' style='height:350px;'>
					</div>
				</div><br>
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Comment</button></a><br>
				</div>
				<div class='col-sm-3'>
				</div>
			</div><br><br>
			";

		}
		else{

		echo "

		<div class='row'>
			<div class='col-sm-3'>
			</div>
			<div id='posts' class='col-sm-6'>
			<div class='row'>
					<div class='col-sm-2'>
						<p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
					</div>
					<div class='col-sm-6'>
						<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
						<h4><small style='color:black;'>Updated a post on <strong>$post_date</strong></small></h4>
					</div>
					<div class='col-sm-4'>

					</div>
				</div>
				<div class='row'>
					<div class='col-sm-2'>
					</div>
					<div class='col-sm-6'>
						<h3><p>$content</p></h3>
					</div>
					<div class='col-sm-4'>

					</div>
				</div>
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Comment</button></a><br>
			</div>
			<div class='col-sm-3'>
			</div>
		</div><br><br>

		";
	}
		include("comments.php");

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
			echo "<script>window.open('single.php?post_id=$post_id','_self')</script>";
			}else{
			$insert = "insert into comments (post_id,user_id,comment,comment_author,date) values ('$post_id','$user_id','$comment','$user_com_name',NOW())";

			$run = mysqli_query($con,$insert);

			echo"<script>alert('Your Reply was added!')</script>";
			echo "<script>window.open('single.php?post_id=$post_id','_self')</script>";
		}

		}

	}
	}

	}


	//function for displaying user posts
	function user_posts(){


	global $con;

			if(isset($_GET['u_id'])){
			$u_id = $_GET['u_id'];
			}
			$get_posts = "select * from posts where user_id='$u_id' ORDER by 1 DESC LIMIT 5";

			$run_posts = mysqli_query($con,$get_posts);

			while($row_posts=mysqli_fetch_array($run_posts)){

			$post_id = $row_posts['post_id'];
			$user_id = $row_posts['user_id'];
			$content = $row_posts['post_content'];
			$upload_image = $row_posts['upload_image'];
			$post_date = $row_posts['post_date'];

			//getting the user who has posted the thread

			$user = "select * from users where user_id='$user_id' AND posts='yes'";

			$run_user = mysqli_query($con,$user);
			$row_user=mysqli_fetch_array($run_user);

			$user_name = $row_user['user_name'];
			$user_image = $row_user['user_image'];






			if(isset($_GET['u_id'])){
			$u_id = $_GET['u_id'];
			}
			$get_posts = "select user_email from users where user_id='$u_id'";
			$run_user = mysqli_query($con,$get_posts);
			$row=mysqli_fetch_array($run_user);

			$user_email = $row['user_email'];

			$user = $_SESSION['user_email'];
			$get_user = "select * from users where user_email='$user'";
			$run_user = mysqli_query($con,$get_user);
			$row=mysqli_fetch_array($run_user);

			$user_id = $row['user_id'];
			$u_email = $row['user_email'];

			if($u_email != $user_email){
				echo"<script>window.open('my_post.php?u_id=$user_id','_self')</script>";
			}else{






			//now displaying all at once

			if($content=="No" && strlen($upload_image) >= 1){

			echo "
			<div class='row'>
				<div class='col-sm-3'>
				</div>
				<div id='posts' class='col-sm-6'>
				<div class='row'>
					<div class='col-sm-2'>
						<p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
					</div>
					<div class='col-sm-6'>
						<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
						<h4><small style='color:black;'>Updated a post on <strong>$post_date</strong></small></h4>
					</div>
					<div class='col-sm-4'>

					</div>
				</div>
				<div class='row'>
					<div class='col-sm-12'>
						<img id='posts-img' src='imagepost/$upload_image' style='height:350px;'>
					</div>
				</div><br>
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Comment</button></a><br>
				</div>
				<div class='col-sm-3'>
				</div>
			</div><br><br>
			";

		}
		else if(strlen($content) >= 1 && strlen($upload_image) >= 1){

			echo "
			<div class='row'>
				<div class='col-sm-3'>
				</div>
				<div id='posts' class='col-sm-6'>
				<div class='row'>
					<div class='col-sm-2'>
						<p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
					</div>
					<div class='col-sm-6'>
						<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
						<h4><small style='color:black;'>Updated a post on <strong>$post_date</strong></small></h4>
					</div>
					<div class='col-sm-4'>

					</div>
				</div>
				<div class='row'>
					<div class='col-sm-12'>
						<p>$content</p>
						<img id='posts-img' src='imagepost/$upload_image' style='height:350px;'>
					</div>
				</div><br>
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Comment</button></a><br>
				</div>
				<div class='col-sm-3'>
				</div>
			</div><br><br>
			";

		}
		else{

		echo "

		<div class='row'>
			<div class='col-sm-3'>
			</div>
			<div id='posts' class='col-sm-6'>
			<div class='row'>
					<div class='col-sm-2'>
						<p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
					</div>
					<div class='col-sm-6'>
						<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
						<h4><small style='color:black;'>Updated a post on <strong>$post_date</strong></small></h4>
					</div>
					<div class='col-sm-4'>

					</div>
				</div>
				<div class='row'>
					<div class='col-sm-2'>
					</div>
					<div class='col-sm-6'>
						<h3><p>$content</p></h3>
					</div>
					<div class='col-sm-4'>

					</div>
				</div>
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Comment</button></a><br>
			</div>
			<div class='col-sm-3'>
			</div>
		</div><br><br>

		";
	}
			include("includes/functions/delete_post.php");
		}

		}






	}

	//function for displaying search results
	function results(){

	global $con;
	if(isset($_GET['search'])){
	$search_query = htmlentities($_GET['user_query']);
	}
	$get_posts = "select * from posts where post_content like '%$search_query%' OR upload_image like '%$search_query%'";
	$run_posts = mysqli_query($con,$get_posts);
	while($row_posts=mysqli_fetch_array($run_posts)){

		$post_id = $row_posts['post_id'];
		$user_id = $row_posts['user_id'];
		$content = substr($row_posts['post_content'],0,40);
		$upload_image = $row_posts['upload_image'];
		$post_date = $row_posts['post_date'];

		//getting the user who has posted the thread
		$user = "select * from users where user_id='$user_id' AND posts='yes'";
		$run_user = mysqli_query($con,$user);
		$row_user=mysqli_fetch_array($run_user);

		$user_name = $row_user['user_name'];
		$first_name = $row_user['f_name'];
		$last_name = $row_user['l_name'];
		$user_image = $row_user['user_image'];

		//now displaying all at onc
		echo "
		<div class='row'>
			<div class='col-sm-3'>
			</div>
			<div id='posts' class='col-sm-6'>
			<div class='row'>
					<div class='col-sm-2'>
						<p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
					</div>
					<div class='col-sm-6'>
						<h3><a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
						<h4><small style='color:black;'>Updated a post on <strong>$post_date</strong></small></h4>
					</div>
					<div class='col-sm-4'>

					</div>
				</div>
				<div class='row'>
					<div class='col-sm-2'>
					</div>
					<div class='col-sm-6'>
						<h3><p>$content</p></h3>
					</div>
					<div class='col-sm-4'>

					</div>
				</div>
				<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Comment</button></a><br>
			</div>
			<div class='col-sm-3'>
			</div>
		</div><br><br>
		";
	}
	}


	//function for displaying search results
	function search_user(){

	global $con;

	if(isset($_GET['search_user_btn'])){
	$search_query = htmlentities($_GET['search_user']);
	$get_user = "select * from users where f_name like '%$search_query%' OR l_name like '%$search_query%' OR user_name like '%$search_query%'";
	}
	else{
	$get_user = "select * from users";
	}

	$run_user = mysqli_query($con,$get_user);

	while($row_user=mysqli_fetch_array($run_user)){

		$user_id = $row_user['user_id'];
		$f_name = $row_user['f_name'];
		$l_name = $row_user['l_name'];
		$username = $row_user['user_name'];
		$user_image = $row_user['user_image'];

		//now displaying all at once

		echo "
		<div class='row'>
			<div class='col-sm-3'>
			</div>

			<div class='col-sm-6'>

			<div class='row' id='find_people'>
			<div class='col-sm-4'>
			<a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>
			<img class='img-circle' src='users/$user_image' width='150px' height='140px' title='$username' style='float:left; margin:1px;'/>
			</a>
			</div><br><br>
			<div class='col-sm-6'>
			<a style='text-decoration: none;cursor: pointer;color: #3897f0;' href='user_profile.php?u_id=$user_id'>
			<strong><h2>$f_name $l_name</h2></strong>
			</a>
			</div>
			<div class='col-sm-3'>
			</div>

			</div>

			</div>
			<div class='col-sm-4'>
			</div>
		</div><br>
		";

	}

	}

	/*
	** Home Redirect Function v2.0
	** This Function Accept Parameters
	** $theMsg = Echo The Message  [ Error | Success | Warning ]
	** $url = The Link You Want To Redirect To
	** $seconds = seconds Before Redirecting
	*/ 
	function redirectHome( $theMsg, $url= null, $seconds = 3 ){

		if ($url === null){

			$url = 'index.php';
			$link = 'Homepage';

		}else{

			if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){

				$url = $_SERVER['HTTP_REFERER'];
				$link = 'Previous Page';

			}else{

				$url = 'index.php';
			 	$link = 'Homepage';

			}
		}
		echo $theMsg ;

		echo "<div class='alert alert-info'>You Will Be Redirected to $link After $seconds Seconds.</div>";

		header("refresh:$seconds;url=$url");

	    exit(); 
	}

?>

