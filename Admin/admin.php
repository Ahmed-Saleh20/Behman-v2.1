<?php

	session_start();
	$pageTitle = "Admin" ; 
	$noNavbar = " ";
	if(isset($_SESSION['adminName'])){
		include 'initialize.php';
		$do = isset($_GET['do']) ? $_GET['do'] : "manage";
		if ($do == 'manage'){ // Manage Page == Home

		//Select All Users Except Admin
		$stmt = $con->prepare("SELECT * FROM users WHERE GroupID !=2 AND GroupID !=3");
		$stmt -> execute();
		$rows = $stmt->fetchAll();

?>			
		<h1 class="text-center">Manage Admins</h1>
		<input class="form-control" id="myInput" type="text" placeholder="Search... "> <br>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table manage-members text-center table table-bordered">
						<tr>
							<td class="table-head">#ID</td>
							<td class="table-head">Username</td>
							<td class="table-head">Email</td>
							<td class="table-head">Registerd Data</td>
							<td class="table-head">Control</td>
						</tr>
					<?php
						foreach($rows as $row){
							echo "<tbody id='myTable'>";
							echo "<tr>"; 
								echo "<td>".$row['user_id']."</td>";
								echo "<td>".$row['user_name']."</td>";
								echo "<td>".$row['user_email']."</td>";
								echo "<td>".$row['user_reg_date']."</td>";
							    echo"<td>
								<a href='admin.php?do=delete&userid=".$row['user_id']."'class='btn btn-danger confirm'>
								<i class='fa fa-close'> </i> Delete </a>
								";
									echo "</td>";
								echo "</tr>";
								echo "</tbody>"; 
						}
					?>
					</table>
				</div>
				<!-- Add New Admin Button -->
				<a href="admin.php?do=add" class="btn btn-info"><i class="fa fa-plus"></i> New Admin </a>
			</div>		
<?php
	    }elseif($do == 'add'){
?>			
		<h1 class="text-center">Add New Admin</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=insert" method="POST">
				<!--Start Username Field-->
					<div class="form-group"> <!-- form-group-> class main form have input and label together -->
						<label class="col-sm-3 control-label">Username</label>
						
						<div class="col-sm-7">
							<input type="text" name="username" class="form-control" autocomplete="off" required="required" 
							placeholder="User Name To Login" />
						</div>
					</div>
				<!--End Username Field-->
				<!--Start Password Field-->
					<div class="form-group"> <!-- form-group-> class main form have input and label together -->
						<label class="col-sm-3 control-label">Password</label>
						<div class="col-sm-7">
							<input type="password" name="password" class="form-control password" autocomplete="new-password" required="required" placeholder="Password Should Be Strong" />
							<i class="fa fa-eye fa-2x  show-pass"></i>
						</div>
					</div>
				<!--End Password Field-->
				<!--Start E-mail Field-->
					<div class="form-group"> <!-- form-group-> class main form have input and label together -->
						<label class="col-sm-3 control-label">E-mail</label>
						<div class="col-sm-7">
							<input type="email" name="email" class="form-control" required="required" placeholder="E-mail Must Be Valid"/>
						</div>
					</div>
				<!--End E-mail Field-->			
				<!--Start Button Save-->
					<div class="form-group"> <!-- form-group-> class main form have input and label together -->
						<div class=" col-sm-offset-3 col-sm-10">
							<input type="submit" value="Add Admin" class="btn btn-primary"/>
						</div>
					</div>
				<!--End Button Save-->

				</form>
			</div>
<?php
	    }elseif ($do == 'insert') {
			
		// Insert Page
			if($_SERVER['REQUEST_METHOD'] == 'POST'){

	    		echo "<h1 class='text-center'>Insert New Member</h1>";
	    		echo "<div class='container'>";

	    		$user = $_POST['username'];
				$pass = $_POST['password'];
				$email = $_POST['email'];

				// Validate The Form

				$formErrors = array();
					if(strlen($user) < 4){//string lenght
						$formErrors[] = 'Username Cant Be Less Than 4 Character '; //push error message in array
					}
					if(empty($user)){
						$formErrors[] = 'Username Cant Be Empty'; 
					}
					if(empty($pass)){
						$formErrors[] = 'Password Cant Be Empty'; 
					}
					if(empty($email)){
						$formErrors[] = 'E-mail Cant Be Empty';
					}

				// Loop Info Errors Array And Echo It
				foreach($formErrors as $error){

					echo '<div class="alert alert-danger">' . $error. '</div>' ;
				}

					// Check If There's No Error Proceed The Update Operation
					if (empty($formErrors)){
						//Check If User Exist in Database
							$check = checkItem("user_name","users", $user);
							if($check == 1 ){
							$theMsg = '<div class="alert alert-danger"> Sorry This User Is Exist</div>';
				    		redirectHome( $theMsg, 'back');

					}else {

					// Insert New Member Info In Database
						$stmt = $con->prepare("
							INSERT INTO users (user_id, f_name, l_name, phone, address, user_name, describe_user, Relationship, user_pass,user_email, user_country, user_gender, user_birthday, user_image, user_cover, user_reg_date, posts,recovery_account, GroupID, CV, Approved, Blocked, Reports) VALUES (NULL, NULL, NULL, NULL, NULL,:zuser,'Administrator',:zpass, :zmail, NULL, NULL, NULL, NULL, NULL, now(), NULL, NULL, '1', NULL, '1', '0', '0')") ;
						$stmt->execute(array(
							'zuser'   => $user,
							'zpass'   => $pass,
							'zmail'   => $email
					));

					$theMsg = "<div class='alert alert-success'>". $stmt->rowCount() . 'Record Insert</div>';
					redirectHome($theMsg,'back');		

					}
					}
	        }else{

	    		$theMsg = '<div class="alert alert-danger"> Sorry You Cant Browse This Page Directly</div>';
	    		redirectHome( $theMsg);
	    	}

	    	    echo "</div>";

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

	    }

	}else{
		header('Location: index.php');
		exit();
	}
?>

<?php
	include $tpl.'footer.php'; 
?>