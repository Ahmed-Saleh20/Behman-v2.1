<?php
include('../../connectDB.php');
//include('../config.php');


switch( $_REQUEST['action'] ){
	// case "sendMessage":
	// 	//global $db;
	// 	session_start();
	// 	$query = $db->prepare("INSERT INTO messages SET user=?, message=?");
	// 	$run = $query->execute([$_SESSION['doc_name'], $_REQUEST['message']]);
	// 	if( $run ){
	// 		echo 1;
	// 		exit;
	// 	}
	// break;
	case "getMessages":
		session_start();
		$query = $con->prepare("SELECT * FROM private_chat");
		$run = $query->execute();
		$rs = $query->fetchAll(PDO::FETCH_OBJ);
		$chat = '';
		foreach( $rs as $message )
		{
			$chat .= '<div class="single-message '.(($_SESSION['user_id']==$message->user_id)?'right':'left').'">
						<strong> '.(($_SESSION['user_id']==$message->user_id)?'You':'Dr').': </strong><br /> <p>'.$message->message.'</p>
						<br />
						<span>'.date("Y-m-d",strtotime($message->date)).' '.date('h:i a', strtotime($message->date)).'</span>
						</div>
						<div class="clear"></div>
						';
		}
		echo $chat;
	break;
}

?>