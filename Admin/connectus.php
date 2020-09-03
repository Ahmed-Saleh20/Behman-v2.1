<?php

	/*
	 * ==================================================
	 * == Manage Admin Page
	 * == You Can Add | Delete Members From Here
	 * ==================================================
	*/

	session_start();
	$pageTitle = "Admin" ; 
	$noNavbar = " ";
	if(isset($_SESSION['adminName'])){
		include 'initialize.php';
		$do = isset($_GET['do']) ? $_GET['do'] : "manage";
		if ($do == 'manage'){ // Manage Page == Home

		//Select All Users Except Admin
		$stmt = $con->prepare("SELECT * FROM ConnectUs");
		$stmt -> execute();
		$rows = $stmt->fetchAll();

?>			
		<h1 class="text-center">Connect Us</h1>
		<input class="form-control" id="myInput" type="text" placeholder="Search... "> <br>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table manage-members text-center table table-bordered">
						<tr>
							<td class="table-head">#ID</td>
							<td class="table-head">Name</td>
							<td class="table-head">Email</td>
							<td class="table-head">Subject</td>
							<td class="table-head">Message</td>
							<td class="table-head">Data</td>
							<td class="table-head">Control</td>
						</tr>
					<?php
						foreach($rows as $row){
							echo "<tbody id='myTable'>";
							echo "<tr>"; 
								echo "<td>".$row['ID']."</td>";
								echo "<td>".$row['Name']."</td>";
								echo "<td>".$row['Email']."</td>";
								echo "<td class='Subject'>".$row['Subject']."</td>";
								echo "<td class='Message'>".$row['Message']."</td>";
								echo "<td>".$row['Date']."</td>";
							    echo"<td>
								<a href='connectus.php?do=delete&id=".$row['ID']."'class='btn btn-danger confirm'>
								<i class='fa fa-close'> </i> Delete </a>
								";
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
			$id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0 ; // intvalue

			// Select All Data Depend On This ID
			$check = checkItem('ID','ConnectUs', $id);

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

	    }

	}else{
		header('Location: index.php');
		exit();
	}
?>

<?php
	include $tpl.'footer.php'; 
?>