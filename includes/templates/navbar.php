<?php
include 'connectDB.php';
?>
	<nav class="navbar navbar-default">
		  <div class="container">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" style="color: red" href="home.php">Behman</a>
		    </div>
		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		      	
		    <?php 
				$useremail = $_SESSION['user_email'];

				$select_user = $con->prepare("SELECT * FROM users WHERE user_email = ?");
				$select_user ->execute(array($useremail));
				$row = $select_user ->fetch();	
						
				$sessionuser_id = $row['user_id']; 
				$user_name = $row['user_name'];
				$first_name = $row['f_name'];
				$last_name = $row['l_name'];
				$user_type = $row['type'];

			    $user_posts = $con->prepare("SELECT * FROM posts WHERE user_id= ?");
				$user_posts ->execute(array($sessionuser_id));
				$posts = $user_posts ->fetch();
				$count = $user_posts ->rowCount();

		    	if($user_type == 1 ){
		    		echo "<li><a href='doc_profile.php?u_id=$sessionuser_id'> $first_name </a></li>";
		    	}else{
		    		echo "<li><a href='user_profile.php?u_id=$sessionuser_id'>$first_name</a></li>";
		    	}
		        
			?>
				<li><a href="members.php">Find People</a></li>
			<?php	
				echo"		
		        <li class='dropdown'>
		          <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'><span><i class='glyphicon glyphicon-chevron-down'></i></span></a>
		          <ul class='dropdown-menu'>
		            <li>
		           <a href='my_post.php?u_id=$sessionuser_id'>My Posts <span class='badge badge-secondary'> $count</span></a>
		            </li>
		            <li>
		            <a href='edit_profile.php?u_id=$sessionuser_id'>Edit My Account</a>
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
		      <ul class="nav navbar-nav navbar-right">
		        <li class="dropdown">
		          <form class="navbar-form navbar-left" method="get" action="search.php">
			        <div class="form-group">
			          <input type="text" class="form-control" name="user_query" placeholder="Search">
			        </div>
			        <button type="submit" class="btn btn-info" name="search">Search</button>
			      </form>
		        </li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
	</nav>