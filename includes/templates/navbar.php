<?php
include 'connectDB.php';
?>
<nav class="navbar navbar-default">
	<div class="container">
	    <div class="navbar-header">

		  <button type="button" class="navbar-right navbar-toggle navbar-btn" data-toggle="collapse" id="sidebarCollapse" aria-expanded="false">
		<!--    <button type="button" class="navbar-right navbar-btn" data-toggle="collapse" id="sidebarCollapse" aria-expanded="false">-->
		   <i class="glyphicon glyphicon-align-left"></i>
		   <span>Toggle Sidebar</span>
		  </button>

	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>

	      <a class="navbar-brand nav-logo" style="color:#31b0d5;font-size:25px;" href="home.php">Behman</a>
	    </div>
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	    <div class="navbar-links">
	      <ul class="nav navbar-nav acenter">
		    <?php
				$useremail = $_SESSION['user_email'];

				$select_user = $con->prepare("SELECT * FROM users WHERE user_email = ?");
				$select_user ->execute(array($useremail));
				$row = $select_user ->fetch();

				$sessionuser_id = $row['user_id'];
				$user_name = $row['user_name'];
				$first_name = $row['f_name'];
				$last_name = $row['l_name'];
				$user_type = $row['GroupID'];

			    $user_posts = $con->prepare("SELECT * FROM posts WHERE user_id= ? and postType ='3' ");
				$user_posts ->execute(array($sessionuser_id));
				$posts = $user_posts ->fetch();
				$count = $user_posts ->rowCount();

            echo "<div class='acenter'></div>";
		    	if($user_type == 2 ){
		    		echo "<li><a href='doc_profile.php?u_id=$sessionuser_id' class='user'><i class='fa fa-user-circle' aria-hidden='true'></i> $first_name </a></li>";
		    	}else{
		    		echo "<li><a href='user_profile.php?u_id=$sessionuser_id' class='user'><i class='fa fa-user-circle' aria-hidden='true'></i> $first_name</a></li>";
		    	}
			?>
			<li><a href="disorders.php"><i class="fa fa-files-o" aria-hidden="true"></i> Articals</a></li>
			<li><a href="./top_videos.php"><i class="fa fa-file-video-o" aria-hidden="true"></i> Videos</a></li>
			<li><a href="members.php"><i class="fa fa-search" aria-hidden="true"></i> FindPeople</a></li>
			<?php
				echo"
		        <li class='dropdown'>
		          <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'><span><i class='glyphicon glyphicon-chevron-down'></i></span></a>
		          <ul class='dropdown-menu'>
		            <li>
		           <a href='privatePosts.php?u_id=$sessionuser_id'>Private Quetions <span class='badge badge-secondary'> $count</span></a>
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
		</div>
          <form class="navbar-form navbar-right" method="get" action="search.php">
	        <div class="form-group">
	          <input type="text" class="form-control search-field" name="user_query" placeholder="Search" required="required">
	        </div>
	        <button type="submit" class="btn btn-info btn-search" name="search">Search</button>
	      </form>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
</nav>
