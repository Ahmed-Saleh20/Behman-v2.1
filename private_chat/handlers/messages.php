<?php
include('../../connectDB.php');
//include('../config.php');


switch( $_REQUEST['action'] ){


	case "getMessages":
		session_start();
		$chat_id = $_SESSION['chat_id'];
		$userown_id = $_SESSION['userown_id'];
		$query = $con->prepare("SELECT * FROM private_chat where chat_id=$chat_id");
		$run = $query->execute();
		$rs = $query->fetchAll(PDO::FETCH_OBJ);
		$chat = '';
		foreach( $rs as $message )
		{
			$chat .= '<div class="single-message '.(($message->message_owner==$userown_id)?'right':'left').'">
						<strong> '.(($_SESSION['userown_id']==$message->message_owner)?'You':'Doctor').' </strong><br /> <p>'.$message->message.'</p>
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