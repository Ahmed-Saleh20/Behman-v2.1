<?php
ob_start(); 

session_start();

	if(isset($_SESSION['adminName'])){
		$noNavbar = " ";
		$pageTitle = 'Admin Dashboard';
		include 'initialize.php';
		/* Start Admin Dashboard */
		$numUsers = 5;
		$numComments = 5;
		$latestUsers = getLatest("*","users","user_id",$numUsers);
		$latestMessage = getLatest("*","connectus","ID",$numComments);
		?>		
		    <div class="home-stats">
				<div class="container text-center"> 
					<h1>Dashboard</h1>
					<div class="row">
						<div class="col-md-3">
							<div class="stat st-members">
								<i class="fa fa-users"></i>
									<div class="info">
									Total Members
									<span><a href="Members.php"><?php echo countItems('user_id','users',3) ?></a></span>
								</div>
							</div>
						</div>						
						<div class="col-md-3">
							<div class="stat st-doctors">
								<i class="fa fa-user-md"></i>
								<div class="info">
								Total Doctors
									<span>
										<a href="doctors.php"><?php echo countItems('user_id','users',2) ?></a>
									</span>
								</div>								
							</div>	
						</div>
						<div class="col-md-3">
							<div class="stat st-pending">
								<i class="fa fa-user-plus"></i>
								<div class="info">					
									Pending Doctors
									<span><a href="doctors.php?do=manage&page=Pending"><?php echo totalPending('user_id','users',2) ?></a></span>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="stat st-comments">
								<i class="fa fa-comments"></i>
								<div class="info">					
									Messages
									<span><a href="connectus.php"><?php echo totalMessages('ID','ConnectUs') ?></a></span>
								</div>
							</div>
						</div>
					</div>
				</div>
		    </div>

			<div class=" latest">
				<div class="container">
					<div class="row">
						<div class="col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-users"></i> Latest  <?php echo $numUsers ?> Registerd Users	
									<span class="toggle-info pull-right">
										<i class="fa fa-minus fa-lg"></i>		
									</span>										
								</div>
								<div class="panel-body">									
								<ul class="list-unstyled latest-users">
								<?php
								if(!empty($latestUsers)){
									foreach ($latestUsers as $key => $user) {
										echo '<li>';
								 			echo $user['user_name'];
								 				echo '<a href="doctors.php"';
												echo '<span class="btn btn-info pull-right">'; //pull-right to align right
												echo '<i class="fa fa-eye"></i> View';
													if($user['Approved'] == 0){
					    								echo "<a href='doctors.php?do=active&userid=".$user['user_id']."'class='btn btn-info pull-right activate' >
					    								<i class='fa fa-close'></i>Approve</a>"; // activite To Edit It in Css
													}
												echo '</span>';
											echo '</a>';
										echo '</li>';	
									}			
								}else{
										echo 'There\'s No Users Yet';
								}	
								?>
								</ul>
								</div>
							</div>	
						</div>
						<div class="col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-tag"></i>  Latest <?php echo $numComments ?> Messages
									<span class="toggle-info pull-right">
										<i class="fa fa-minus fa-lg"></i>		
									</span>
								</div>
								<div class="panel-body">
									<ul class="list-unstyled latest-users">
								<?php
									if(! empty($latestMessage)){
										foreach ($latestMessage as $key => $Messages) {
										echo '<li>';
								 			echo $Messages['Message'];
											echo '<a href="connectus.php"';
												echo '<span class="btn btn-info pull-right">'; //pull-right to align right
													echo '<i class="fa fa-eye"></i> View';
												echo '</span>';
											echo '</a>';
										echo '</li>';	
										}		
									}else{
										echo 'There\'s No Items Yet';
									}		
								?>
									</ul>									
								</div>
							</div>	
						</div>							
					</div>				
				</div>
			</div>

<?php
		/* End Admin Dashboard */
		include $tpl.'footer.php';
	}else{
				
	    // echo "You Are Not Authorized To View This Page";
		header('Location: index.php');
		exit();
	}
	ob_end_flush(); //Release The Output
?>	