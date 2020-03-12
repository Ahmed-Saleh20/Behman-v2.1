<?php
  	session_start();
  	$pageTitle = "Edit" ;
	$noNavbar = ''; 
	include("initialize.php");

	if(!isset($_SESSION['user_email'])){
		header("location: index.php");
	}else{ 
?>
<div class="row">
	<div class="col-sm-2"> </div>
	<div class="col-sm-8">
		<form action="" method="post" enctype="multipart/form-data">
			<table class="table table-bordered table-hover">
				<tr align="center">
					<td colspan="6" class="active"><h2>Edit Your Profile</h2></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Change Your Firstname</td>
					<td>
					<input class="form-control" type="text" name="f_name" required="required" value="<?php echo $first_name;?>"/>
					</td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Change Your Lastname</td>
					<td>
					<input class="form-control" type="text" name="l_name" required="required" value="<?php echo $last_name;?>"/>
					</td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Change Your Username</td>
					<td>
					<input class="form-control" type="text" name="u_name" required="required" value="<?php echo $user_name;?>"/>
					</td>
				</tr>

				<tr>
					<td style="font-weight: bold;">Description</td>
					<td>
					<input class="form-control" type="text" name="describe_user" required="required" value="<?php echo $describe_user;?>"/>
					</td>
				</tr>

				<tr>
					<td style="font-weight: bold;">Relationship Status</td>
					<td>
					<select class="form-control" name="Relationship">
						<option><?php echo $Relationship_status;?></option>
						<option>Engaged</option>
						<option>Married</option>
						<option>Single</option>
						<option>In an Replationship</option>
						<option>It's complicated</option>
						<option>Separated</option>
						<option>Divorced</option>
						<option>Widowed</option>
					</select>
					</td>
				</tr>
				
				<tr>
					<td style="font-weight: bold;">Password</td>
					<td>
					<input class="form-control" type="password" name="u_pass" id="mypass" required="required" value="<?php echo $user_pass;?>"/><!-- onfocus="this.value=''" -->
					<input type="checkbox" onclick="show_password()"> <strong>Show Password</strong>
					</td>
				</tr>
				
				<tr>
					<td style="font-weight: bold;">Email</td>
					<td>
					<input class="form-control" type="email" name="u_email" required="required" value="<?php echo $user_email;?>"></td>
				</tr>
				
				<tr>
					<td style="font-weight: bold;">Country</td>
					<td>
					<select class="form-control" name="u_country">
						<option><?php echo $user_country;?></option>
						<option>Afghanistan</option>
						<option>India</option>
						<option>Pakistan</option>
						<option>United States</option>
						<option>United Arab Emirates</option>
					</select>
					</td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Gender</td>
					<td>
					<select class="form-control" name="u_gender">
						<option><?php echo $user_gender;?></option>
						<option>Male</option>
						<option>Female</option>
						<option>Other</option>
					</select>
					</td>
				</tr>
				
				<tr>
					<td style="font-weight: bold;">Birthday</td>
					<td>
					<input type="date" name="u_birthday" class="form-control input-md" value="<?php echo $user_birthday;?>" required="required" >
				</tr>
				

				<!-- recovery option start -->
				<tr>
					<td style="font-weight: bold;">Forgotten Password</td>
					<td>
					<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Turn On</button>

					<!-- Modal -->
					<div id="myModal" class="modal fade" role="dialog">
					  <div class="modal-dialog">

					    <!-- Modal content-->
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					        <h4 class="modal-title">Modal Header</h4>
					      </div>
					      <div class="modal-body">
					        <form action="recovery.php?id=<?php echo $user_id;?>" method="post" id="f">
							<strong>What is your School Best Friend Name?</strong>
							<textarea class="form-control" cols="83" rows="4" name="content" placeholder="Someone"></textarea><br/>
							<input class="btn btn-default" type="submit" name="sub" value="Submit" style="width:100px;" /><br><br>
							<pre >Answer the above question we will ask you this question if you forgot your <br>password.
							</pre>
							<br><br>
							</form>
							<?php
							if(isset($_POST['sub'])){
								$bfn = htmlentities($_POST['content']);

								if($bfn==''){
								echo "<script>alert('Please Enter Something!')</script>";
								echo "<script>window.open('edit_profile.php?u_id=$user_id','_self')</script>";
								exit();
								}
								else {
								$update = $con->prepare("UPDATE users set recovery_account='$bfn' where user_id='$user_id'");
								$update ->execute();
								$row = $update ->fetch();	 
								if($row){
								
								echo "<script>alert('Working...!')</script>";
								echo "<script>window.open('edit_profile.php?u_id=$user_id','_self')</script>";
								}else{
								echo "<script>alert('Error while Updating information...!')</script>";
								echo "<script>window.open('recovery.php','_self')</script>";
								}
								}
							}
							?>
							<!-- recovery option ends -->

					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					      </div>
					    </div>

					  </div>
					</div>
				</tr>
				
				<tr align="center">
					<td colspan="6">
					<input class="btn btn-info" style="width: 250px;" type="submit" name="update" value="Update"/>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div class="col-sm-2"> </div>
</div>
					
<?php 
	if(isset($_POST['update'])){
	
		$f_name = htmlentities($_POST['f_name']);
		$l_name = htmlentities($_POST['l_name']);
		$u_name = htmlentities($_POST['u_name']);
		$describe_user = htmlentities($_POST['describe_user']);
		$Relationship_status = htmlentities($_POST['Relationship']);
		$u_pass = htmlentities($_POST['u_pass']);
		$u_email = htmlentities($_POST['u_email']);
		$u_country = htmlentities($_POST['u_country']);
		$u_gender = htmlentities($_POST['u_gender']);
		$u_birthday = htmlentities($_POST['u_birthday']);
	
		$update = $con->prepare("UPDATE users 
								set 
								f_name='$f_name', l_name='$l_name',user_name='$u_name',
								describe_user='$describe_user',Relationship='$Relationship_status',
								user_pass='$u_pass',user_email='$u_email',user_country='$u_country',
								user_gender='$u_gender',user_birthday='$u_birthday' 
								where 
								user_id='$user_id'");
		$update ->execute();
				 
		if($update){
			echo "<script>alert('Your Profile Updated!')</script>";
			echo "<script>window.open('user_profile.php?u_id=$user_id','_self')</script>";
		}
	}
?>
<?php } ?>
<script>
function show_password() {
    var x = document.getElementById("mypass");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>
<?php
	include 'includes/templates/footer.php';
?>