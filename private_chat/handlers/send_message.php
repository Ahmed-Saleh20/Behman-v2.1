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
		$chat_id = $_POST['chat_id'];
		$userown_id = $_POST['userown_id'];
		
	    if ($message !=null && $userown_id !=null && $chat_id !=null) {
			$insert = $con->prepare("INSERT into private_chat(message_owner,chat_id,message)values('$userown_id','$chat_id','$message')");
			$insert ->execute();
		}

	}

?>
<?php }?>
<?php
	include '../../includes/templates/footer.php';
?>
