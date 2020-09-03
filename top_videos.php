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

		  }  }
		?>

	</div>

<?php
include 'select_top_videos.php';
 ?>

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

