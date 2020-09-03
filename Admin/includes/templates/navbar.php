<?php
include 'connectDB.php';
?>
<nav class="navbar navbar-inverse">
	  <div class="container">
	    <div class="navbar-header">
	    	
		  <button type="button" class="navbar-right navbar-toggle navbar-btn" data-toggle="collapse" id="sidebarCollapse"aria-expanded="false">
		  <i class="glyphicon glyphicon-align-left"></i>
		  <span>Toggle Sidebar</span>
		  </button>

	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>

	      <a class="navbar-brand" style="color: Orange ;font-size: 20px">Behman</a>
	    </div>
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	    <div class="navbar-links">	
	      <ul class="nav navbar-nav">
		    <?php 
				$username = $_SESSION['adminName'];

				$select_user = $con->prepare("SELECT * FROM users WHERE user_name = ?");
				$select_user ->execute(array($username));
				$row = $select_user ->fetch();	
						
				$sessionuser_id = $row['user_id']; 
				$user_name = $row['user_name'];

		        
			?>
			<li><a href="Dashboard.php">Home</a></li>
			<li><a href="doctors.php">Doctors</a></li>
			<li><a href="Members.php">Members</a></li>
			<li><a href="connectus.php">Messages</a></li>

			<?php	
				echo"		
		        <li class='dropdown admin-dropdown'>
		          <a href='#' class='dropdown-toggle ad-dropdown' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Welcome $username <span><i class='glyphicon glyphicon-chevron-down'></i></span></a>
		          <ul class='dropdown-menu'>
		            <li>
		            <a href='admin.php'>Add Another Admin</a>
		            </li>
		            <li role='separator' class='divider'></li>
		            <li>
		            <a href='logout.php'>Logout</a>
		            </li>
		          </ul>
		        </li>
		      </ul>
		      ";
		    ?>
		</div>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
</nav>