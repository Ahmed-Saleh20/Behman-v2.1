<?php
	session_start();
	$pageTitle = "Playlists" ; 
	$noNavbar = ''; 
	include("../../initialize.php");
	if(!isset($_SESSION['user_email'])){
		header("location: index.php");
	}else{ 
?>

<?php 
	
	if(isset($_POST['send_message'])){
		$message = $_POST['message'];
		$doc_id = $_POST['doc_id'];
		$user_id = $_POST['user_id'];
		
	    if ($message !=null && $doc_id !=null && $user_id !=null) {
			$insert = $con->prepare("INSERT into private_chat(doc_id,user_id,message)values('$doc_id','$user_id','$message')");
			$insert ->execute();
		}

	}

?>
<?php }?>
<?php
	include '../../includes/templates/footer.php';
?>
