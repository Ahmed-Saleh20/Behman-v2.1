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
		<input id="myInput" type="text" placeholder="Search... "> <br><br>
	</div>
<div class="users_data" >
		<table>
			<tr>
				<th>post_id</th>
				<th>post_content</th>
				<th>post_date</th>
				<th>postType</th>
				<th>status</th>
				<th>p_reports</th>
				<th>Action</th>
				
			</tr>
			<form method='post'>
			<?php
			$user_data = $con->prepare("SELECT * FROM posts ORDER BY p_reports DESC ");
			$user_data ->execute();
			$posts = $user_data ->fetchall();

		foreach ($posts as $key => $post)
		{
		    $post_id = $post['post_id'];
		    $post_content = $post['post_content'];
		    $post_date = $post['post_date'];
		    $postType=$post['postType'];
		    $status=$post['status'];
		    $p_reports=$post['p_reports'];
		    echo "<tbody id='myTable'>";
	        echo "<tr> ";
	        echo "<td>".$post_id."</td>";
	        echo "<td>".$post_content."</td>";
	        echo "<td>".$post_date."</td>";
	        echo "<td>".$postType."</td>";
	        echo "<td>".$status."</td>";
	        echo "<td>".$p_reports."</td>";
		    echo "<td>"."<button id='b3' name='b".$post_id."' class='users_data_button1' > view</button>
		                 <button id='b3' name='d".$post_id."' class='users_data_button2' > delte</button>  
		         "."</td>";
		    
		    echo "</tr> ";
		    echo "</tbody>";
		    if (isset($_POST['d'.$post_id])) {
              	 
                    $user_data3 = $con->prepare("DELETE  FROM `posts` WHERE post_id =$post_id ");
					$user_data3 ->execute();

                 }
		    
		}


				  ?>
				  </form>
			</table>
	</div>