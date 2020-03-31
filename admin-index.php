<?php
include 'initialize.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>admin-index</title>
	<link rel="stylesheet" href="layout/css/Main.css" >
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
		$(document).ready(function(){
		  $("#myInput").on("keyup", function() {
		    var value = $(this).val().toLowerCase();
		    $("#myTable tr").filter(function() {
		      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		    });
		  });
		});
	</script>	
</head>
<body>
	
	<div class="admin_tasks" >
		<h1>
			 Dashboard
		</h1>
		<table>
			<tr>
				<td>  <div class="dropdown">
						  <button class="dropbtn"><a href="admin-posts-list.php">posts</a></button>
						  
					  </div>
				</td>
				<td>|</td> 
				<td>  <div class="dropdown">
						  <button class="dropbtn">doctors</button>
						  <div class="dropdown-content">
							  <a href="admin-old-doc-list.php">old-doctors</a>
							  <a href="admin-new-doc-list.php">new-doctors</a>
							  <a href="admin-blocked-doc-list.php">blocked-doctors</a>
							 
						  </div>
					  </div>
				</td>
				<td>|</td>
				<td>  <div class="dropdown">
						  <button class="dropbtn">users</button>
						  <div class="dropdown-content">
							  <a href="admin-index.php">all users</a>
							  <a href="admin-blocked-users-list.php">blocked users</a>
							  
						  </div>
					  </div>
				</td>
			</tr>
		</table> <br>
		<input id="myInput" type="text" placeholder="Search..."> <br><br>
	</div>
    
	
	
	<div class="users_data" >
		<table>
			<tr>
				<th>name</th>
				<th>email</th>
				<th>password</th>
				<th>Action</th>
				
			</tr>
			
			<?php
			$user_data = $con->prepare("SELECT * FROM users WHERE type='2'and user_block='0'");
		$user_data ->execute();
		$posts = $user_data ->fetchAll();

		foreach ($posts as $key => $post)
		{
		    $first_name = $post['f_name'];
		    $email = $post['user_email'];
		    $password = $post['user_pass'];
		    $id=$post['user_id'];
		    echo "<tbody id='myTable'>";
	        echo "<tr> <form method='post'> ";
	        echo "<td>".$first_name."</td>";
	        echo "<td name='e22'>".$email."</td>";
	        echo "<td>".$password."</td>";
		    echo "<td>"."<button id='b3' name='b".$id."' class='users_data_button1' > block</button>
		                 <button id='b3' name='d".$id."' class='users_data_button2' > delte</button>
		                   
		         "."</td>";
		   
		    echo "</tr> </form> ";
		    echo "</tbody>";
		    
		    if (isset($_POST['b'.$id])) {
              	 
                    $user_data2 = $con->prepare("UPDATE `users` SET `user_block`=1 WHERE user_id =$id ");
					$user_data2 ->execute();

                 }
            if (isset($_POST['d'.$id])) {
              	 
                    $user_data3 = $con->prepare("DELETE  FROM `users` WHERE user_id =$id ");
					$user_data3 ->execute();

                 }
		    

		    
		}


				  ?>
				 
			</table>
	</div>


	


  
</body>
</html>

