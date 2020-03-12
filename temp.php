<?php
	session_start();
	$noNavbar = '';
	if(!isset($_SESSION['user_email'])){
	 header("location: index.php");
	}else{   
  		include 'initialize.php';	
?>
<?php
	$do = isset($_GET['do']) ? $_GET['do'] : "manage";
	
	// Start Manage Page
	if ($do == 'manage'){ 

		echo 'WELCOME';

	}elseif ( $do == 'insert') {

	}elseif($do == 'edit'){

	}elseif($do == 'delete'){

	}
}	

		$get_posts = $con->prepare("SELECT * from posts where post_id='$get_id'");
		$get_posts ->execute();
		$row_posts = $get_posts ->fetch();
		$count = $stmt->rowCount();	

		$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;
?>
<?php }?>
<?php
	include 'includes/templates/footer.php';
?>