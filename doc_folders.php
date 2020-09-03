
<?php
	session_start();
	$pageTitle = "files" ; 
	$noNavbar = ''; 
	include("initialize.php");
	if(!isset($_SESSION['user_email'])){
		header("location: index.php");
	}else{
?>

    <?php
    
	    $user_id = isset($_GET['u_id']) && is_numeric($_GET['u_id']) ? intval($_GET['u_id']) : 0 ;

		$stmt = $con->prepare("SELECT * FROM users WHERE user_id = ? AND GroupID = '2'");
		$stmt->execute(array($user_id));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();

		if($count > 0 ){
			$id = $row['user_id'];
			$name = $row['user_name'];
			$f_name = $row['f_name'];
			$l_name = $row['l_name'];
			$user_image = $row['user_image'];

			/* Check IF User Is Owner User */
			$user = $_SESSION['user_email'];
			$get_user  = $con->prepare("SELECT * from users where user_email='$user'");
			$get_user  ->execute();
			$row = $get_user  ->fetch();	
			$userown_id = $row['user_id'];
			$user_name = $row['user_name'];
		}

?>
<link href="includes/doc_attachments/local_css.css" rel="stylesheet">

	<div style="height: 280px; width: 140px; background-color: #CCC;margin-left: -2px;margin-top:130px;border-top-right-radius:8px;border-bottom-right-radius:8px; position: fixed;">

		<div style="margin-top: -150px;" class="profile">
				<a href='doc_profile.php?u_id=<?php echo $user_id;?>' title="view profile" style="text-decoration: none;"><img 
					src='includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.png'; } ?>' 
					            	class='img-circle img-shadow'
					            	alt='Profile' 	 
					            	width='60px' 
					            	height='60px' 
				 /><?php echo "<h5 style='text-align:center;font-weight:bold;color:black;'>$f_name</h5>"; ?></a>
		</div>
		<form action='doc_folders.php?u_id=<?php echo $user_id ?>' method='POST' enctype='multipart/form-data'>
			<center style="margin-top: 145px;">
			    <button style=" font-weight:bold;width: 120px;border-bottom-right-radius: 20px;border-top-right-radius: 20px;" class='btn btn-info'>Files</button>
			</center>
		</form>
		<form action='playlists.php?u_id=<?php echo $user_id ?>' method='POST' enctype='multipart/form-data'>
			<center style="margin-top: 10px;">
			    <button style="font-weight:bold;width: 120px;border-bottom-right-radius: 20px;border-top-right-radius: 20px;" class='btn btn-info'>Playlists</button>
			</center>
		</form>
	</div>



    <div style="margin-left: 160px;margin-right: 25px;display: inline-flex;" class="card shadow mb-4">

        <div class="card-header py-3">
		<?php
		if ($user_id == $userown_id) {
		 ?>
	    <form action='doc_folders.php?u_id=<?php echo $user_id ?>' method='POST' enctype='multipart/form-data'>
	       <label style="display: inline-flex;margin-left: 800px;margin-bottom: -30px;margin-top: 8px;"><input class="form-control" type="text" name="folder_name" placeholder="Folder Name" required="" style="width:200px;"></label>

		    <button  style="margin-bottom: -30px; border:gray solid 0.5px;float:right;margin:7px;margin-right:30px;"  name='create_folder' class='btn '><img src="includes/doc_attachments/playlist/icons/plus.png" style="width: 15px;height: 15px;"> Create Folder</button>
	    </form>

	<?php } ?>
        </div>
    <!-- start display playlists -->

    <?php 
    	if ($user_id != $userown_id) {
    		?><div  style="padding:2rem 1rem 1rem 6rem;min-width: 1185px;min-height:560px; background-color: #F1F1F1;" class="card-body"><?php

    	} else {
    		?><div  style="padding:2rem 1rem 1rem 6rem;min-width: 1185px;min-height:520px; background-color: #F1F1F1;" class="card-body">
    	<?php } ?>


		<?php 

		    $stmt = $con->prepare("SELECT * FROM folder WHERE  user_id = $user_id AND parent_id =0");
			$stmt->execute(array($user_id));
			$folders   = $stmt->fetchAll();
			$folders_count = $stmt->rowCount();
			if ($folders_count) {
			?><h4 style="margin-left: 8px;color: rgba(0,0,0,0.55);">Folders</h4>
			<?php
			foreach ($folders as $key => $folder){
				$folder_id   = $folder['folder_id'];
				$folder_name = $folder['folder_name'];
				$folder_time = $folder['folder_time'];
				$privacy     = $folder['privacy'];
            ?>
            	<div class="task" data-id="2" style="display:inline-flex;">
            		<a href="doc_files.php?parent_id=<?php echo $folder_id ?>" title="<?php echo $folder_name;?>" style="text-decoration:none;">
	            		<div class="card-header shadow" style=" white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width:220px;height:50px; margin:5px;padding-top:rem; border-radius:6px;">
	            			<img src="includes/doc_attachments/folder/icons/folder.png" style="width: 26px;height: 26px;margin:14px;margin-top:8px;">
	            			<span style="margin-left:-10px; color:rgba(0,0,0,0.72);font-size: 20px; white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><?php echo $folder_name;?></span>
	            		</div>
	            	</a>
	            </div>
            
		       
<?php 
	}
	}

	else
		{
			echo "<center style='margin-left:340px;margin-top:250px;margin-right:435px;margin-bottom:140px;color:rgba(0,0,0,0.6)'><h3>there are no Filders or files yet!<h3><center>";
		}?>

      </div>
    </div>


    <?php 

    	if (isset($_POST['create_folder'])) {
    		$folder_name = htmlentities($_POST['folder_name']);
    		$privacy =1;
    		$parent_id =0;
    		if ($folder_name =='') {
	        	echo "<script>alert('please insert folder name !')</script>";
	        	echo "<script>window.open('doc_folders.php?u_id=$user_id','_self')</script>";	
    		}
    		else
    		{
				$insert = $con->prepare("INSERT into folder(folder_name,privacy,parent_id,user_id)values('$folder_name','$privacy','$parent_id','$userown_id')");
				$insert ->execute();                
			    
			    if($insert){
			          	 //echo "<script>alert('playlist added!')</script>";
			        echo "<script>window.open('doc_folders.php?u_id=$user_id','_self')</script>";
			  	}
    		}
    	}

    ?>


<?php } ?>
	<?php
	include 'includes/templates/footer.php';
?>
