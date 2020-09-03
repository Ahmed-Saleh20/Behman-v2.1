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

function getAll($table){

	global $con ;
	$getStmt = $con ->prepare("SELECT * FROM $table ORDER BY user_id DESC");
	$getStmt -> execute();
	$rows = $getStmt -> FetchAll();
	return $rows;

} 
function totalMessages($item, $table){

	global $con ;
	$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
	$stmt2 -> execute();
	return $stmt2->fetchColumn();

}
function totalPending($item, $table, $groupID){

	global $con ;
	$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table WHERE GroupID = $groupID AND Approved = 0");
	$stmt2 -> execute();
	return $stmt2->fetchColumn();

}

/*
** Get Latest Records Function v1.0
** Function To Get Latest Items From Database [ Users , Items , Comments ]
** $select = Faild To Select
** $table  = The table to Choose Form 
** $order  = The Ordering by
** $limit  = Number Of Records To Get
*/

function getLatest($select, $table, $order, $limit = 5 ){

	global $con;

	$getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
	$getStmt -> execute();
	$rows = $getStmt -> FetchAll();
	return $rows;

}

/*
** Count Number Of Items Function v1.0
** Function To Count Number Of Items Rows
** $item  = The Item To Count
** $table = The Table To Choose From
** $GroupID   = Type of Member
*/

function countItems($item, $table, $groupID){

	global $con ;
	$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table WHERE GroupID = $groupID");
	$stmt2 -> execute();
	return $stmt2->fetchColumn();

}

/*
** Check Items Function v1.0
** Function to Check Item In Database [ Function Accept Parmeters ]
** $select = The Item To Select [ Example: username, item, category ] iN DATABASE
** $from   = The Table To Select From [ Example: users, items, categories ]
** $value  = The Value Of Select [ Example: Ahmed, Box, Electronics ]
*/

function checkItem($select,$from,$value){

	global $con ;
	$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
	$statement->execute(array($value));
	$count = $statement->rowCount();
	return $count ;

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

	include 'includes/templates/footer.php';
?>
