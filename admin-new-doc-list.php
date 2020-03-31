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
			<form method='post'>
			<?php
			$user_data = $con->prepare("SELECT * FROM users WHERE type='1'and approved='0'");
		$user_data ->execute();
		$posts = $user_data ->fetchall();

		foreach ($posts as $key => $post)
		{
		    $first_name = $post['f_name'];
		    $email = $post['user_email'];
		    $password = $post['user_pass'];
		    $id=$post['user_id'];
		    echo "<tbody id='myTable'>";
	        echo "<tr> ";
	        echo "<td>".$first_name."</td>";
	        echo "<td>".$email."</td>";
	        echo "<td>".$password."</td>";
		    echo "<td>"."<button id='b3' name='ap".$id."' class='users_data_button1' > approve </button> "."</td>";
		   
		    echo "</tr> ";
		    echo "</tbody>";
		    if (isset($_POST['ap'.$id])) {
              	 
                    $user_data2 = $con->prepare("UPDATE `users` SET `approved`=1 WHERE user_id =$id ");
					$user_data2 ->execute();

                 }

		    
		}


				  ?>
				  </form>
			</table>
	</div>