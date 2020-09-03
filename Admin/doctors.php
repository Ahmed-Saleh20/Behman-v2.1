<?php

	session_start();
	$pageTitle = "Doctors" ; 
	$noNavbar = " ";
	if(isset($_SESSION['adminName'])){
		include 'initialize.php';
		$do = isset($_GET['do']) ? $_GET['do'] : "manage";
		if ($do == 'manage'){ // Manage Page == Home
			$query = '';
			if( isset($_GET['page']) && $_GET['page'] == 'Pending'){

				$query = 'AND Approved = 0';

			}
		//Select All Users Except Admin
		$stmt = $con->prepare("SELECT * FROM users WHERE GroupID !=1 AND GroupID !=3 $query");
		$stmt -> execute();
		$rows = $stmt->fetchAll();

?>			
		<h1 class="text-center">Manage Doctors</h1>
		<input class="form-control" id="myInput" type="text" placeholder="Search... "> <br>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table manage-members text-center table table-bordered">
						<tr>
							<td class="table-head">#ID</td>
							<td class="table-head">Avatar</td>
							<td class="table-head">Username</td>
							<td class="table-head">Email</td>
							<td class="table-head">Reports</td>
							<td class="table-head">Registerd Data</td>
							<td class="table-head">CV</td>
							<td class="table-head">Control</td>
						</tr>
					<?php
						foreach($rows as $row){
							echo "<tbody id='myTable'>";
							echo "<tr>"; 
								echo "<td>".$row['user_id']."</td>";
								echo "<td>";
								if (empty($row['user_image'])){
									echo "No Image";
								}else{
									echo "<img src='../includes/images/users/" .$row['user_image']."' alt=''/>";
								}
								"</td>";
								echo "<td>".$row['user_name']."</td>";
								echo "<td>".$row['user_email']."</td>";
								echo "<td>".$row['Reports']."</td>";
								echo "<td>".$row['user_reg_date']."</td>";
								echo "<td>.<a href='doctors.php?do=viewCV&userid=".$row['user_id']."'class='btn btn-Success' ><i class='fa fa-eye'></i> View</a>.</td>";
							    echo"<td>
								<a href='doctors.php?do=delete&userid=".$row['user_id']."'class='btn btn-danger confirm'>
								<i class='fa fa-close'> </i> Delete </a>
								";
								if($row['Blocked'] == 0){			    	
								    echo "<a href='doctors.php?do=block&userid=".$row['user_id']."'class='btn btn-warning confirm' >
								    <i class='fa fa-lock'></i> Block</a>"; 
								}else{
									echo "<a href='doctors.php?do=unblock&userid=".$row['user_id']."'class='btn btn-default confirm' >
								    <i class='fa fa-unlock'></i> Unblock</a>";
								}
								//Appear Activation Button If RegStatus = 0 
								if($row['Approved'] == 0){
											    	
								    echo "<a href='doctors.php?do=active&userid=".$row['user_id']."'class='btn btn-info activate' >
								    <i class='fa fa-check'></i>Approve</a>"; // activite To Edit It in Css

								}
									echo "</td>";
								echo "</tr>";
								echo "</tbody>"; 
						}
					?>
					</table>
				</div>
			</div>		
<?php
	    }elseif ( $do == 'delete'){

	    	echo "<h1 class='text-center'>Deleted Doctor</h1>";
			echo "<div class='container'>";	    	

	    	// Check If GET Request userid Is Numeric & GET The Integer Value Of it
			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ; // intvalue

			// Select All Data Depend On This ID
			$check = checkItem('user_id','users', $userid);

            // We can replace this code with checkitem function
			//$stmt = $conn->prepare("SELECT * FROM users WHERE userid = ? ");
			//$stmt->execute(array($userid));
			//$row = $stmt->fetch();
			//$count = $stmt->rowCount();

			// If There's Such ID Show The Form
				if($check > 0 )
				{
					// echo 'Good This ID Is Exist' ;
					$stmt = $con->prepare("DELETE FROM users WHERE user_id = :zuser") ;
					$stmt->bindParam(":zuser", $userid); 
					$stmt->execute(); 

					$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . ' Record Deleted </div>';	
		    		redirectHome($theMsg,'back');

				}else{

					$theMsg = "<div class='alert alert-danger'>This ID Is Not  Exist</div>"	;
	    			redirectHome($theMsg);
				}

			echo '</div>';

	    }elseif($do == 'block'){

	    	echo "<h1 class='text-center'>Blocked Member</h1>";
	    	echo "<div class='container'>";	    	

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ; 
			$check = checkItem('user_id','users', $userid);
			if($check > 0 )
			{
				$stmt = $con->prepare("UPDATE users SET Blocked = 1 WHERE user_id = ? ") ;
				$stmt->execute(array($userid));
				$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . ' Doctor Blocked </div>';	
	    		redirectHome($theMsg,'back');
				echo '</div>';
			}else{
				$theMsg = "<div class='alert alert-danger'>This ID Is Not  Exist</div>"	;
	    		redirectHome($theMsg);
			}

	    }elseif($do == 'unblock'){

	    	echo "<h1 class='text-center'>Unblocked Member</h1>";
	    	echo "<div class='container'>";	    	

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ; 
			$check = checkItem('user_id','users', $userid);
			if($check > 0 )
			{
				$stmt = $con->prepare("UPDATE users SET Blocked = 0 WHERE user_id = ? ") ;
				$stmt->execute(array($userid));
				$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . ' Doctor Unblocked </div>';	
	    		redirectHome($theMsg,'back');
				echo '</div>';
			}else{
				$theMsg = "<div class='alert alert-danger'>This ID Is Not  Exist</div>"	;
	    		redirectHome($theMsg);
			}

	    }elseif ( $do == 'active'){
	    	
	    	echo "<h1 class='text-center'>Approved Doctor</h1>";
	    	echo "<div class='container'>";	    	

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ; 
			$check = checkItem('user_id','users', $userid);
			if($check > 0 )
			{
				$stmt = $con->prepare("UPDATE users SET Approved = 1 WHERE user_id = ? ") ;
				$stmt->execute(array($userid));
				$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . ' Record Activeted </div>';	
	    		redirectHome($theMsg,'back');
				echo '</div>';
			}else{
				$theMsg = "<div class='alert alert-danger'>This ID Is Not  Exist</div>"	;
	    		redirectHome($theMsg);
			}
	    }elseif($do == 'viewCV'){
			
		   $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ; 
		   $CVs = $con->prepare("SELECT CV from users where user_id = '$userid'");
		   $CVs ->execute();
		   $rows = $CVs ->fetchAll();
		   foreach ($rows as $key => $row) {
		   	   $file = "../includes/doc_attachments/CVs/".$row['CV'];
			   $filename =  "../includes/doc_attachments/CVs/".$row['CV'];
			   header('Content-type: application/pdf');
			   header('Content-Disposition: inline; filename="'. $filename . '"');
			   header('Content-Transfer-Encoding: binary');
			   header('Accept-Ranges: bytes');
			   @readfile($file);
		   }
	    }

	}else{
		header('Location: index.php');
		exit();
	}
?>

<?php
	include $tpl.'footer.php'; 
?>
