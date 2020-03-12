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
	
?>