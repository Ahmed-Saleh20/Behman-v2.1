
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
    
	    $folder_id = isset($_GET['parent_id']) && is_numeric($_GET['parent_id']) ? intval($_GET['parent_id']) : 0 ;

		$stmt = $con->prepare("SELECT * FROM folder WHERE  folder_id = $folder_id");
	    $stmt->execute();
		$row   = $stmt->fetch();
		$count = $stmt->rowCount();
		if ($count) {
			$user_id = $row['user_id'];	
		}



		$stmt = $con->prepare("SELECT * FROM users WHERE user_id = $user_id AND type = '1'");
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
<link href="includes/doc_attachments/css-file-icons.css" rel="stylesheet">
<div style="height: 280px; width: 140px; background-color: #CCC;margin-left: -2px;margin-top:130px;border-top-right-radius:8px;border-bottom-right-radius:8px; position: fixed;">

		<div style="margin-top: -180px;" class="profile">
			<a href='doc_profile.php?u_id=<?php echo $user_id;?>' title="view profile" style="text-decoration: none;"><img 
				src='includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.png'; } ?>' 
				            	class='img-circle'
				            	alt='Profile' 	 
				            	width='50px' 
				            	height='50px' 
			 /><?php echo "<h5 style='margin-left:-13px;font-weight:bold;color:black;'>$f_name</h5>"; ?></a>
	</div>

	<form action='playlists.php?u_id=<?php echo $user_id ?>' method='POST' enctype='multipart/form-data'>
		<center style="margin-top: 100px;">
		    <button style=" font-weight:bold;width: 120px;border-bottom-right-radius: 20px;border-top-right-radius: 20px;" class='btn btn-info'>Playlists</button>
		</center>
	</form>
	<form action='doc_folders.php?u_id=<?php echo $user_id ?>' method='POST' enctype='multipart/form-data'>
		<center style="margin-top: 10px;">
		    <button style="font-weight:bold;width: 120px;border-bottom-right-radius: 20px;border-top-right-radius: 20px;" class='btn btn-info'>Files</button>
		</center>
	</form>
	</div>



    <div style="margin-left: 160px;margin-right: 25px;display: inline-flex;" class="card shadow mb-4">

        <div class="card-header py-3">
		<?php
		if ($user_id == $userown_id) {
		 ?>


		<form action='doc_files.php?parent_id=<?php echo $folder_id ?>' method='POST' enctype='multipart/form-data'>
	       <label style="display: inline-flex;margin-left: 800px;margin-bottom: -30px;margin-top: 8px;"> <input class="form-control" type="text" placeholder="Folder Name" name="folder_name" required="" style="width:220px;"></label>

		    <button  style="margin-bottom: -30px; border:gray solid 0.5px;float:right;margin:7px;margin-right:30px;width:120px;"  name='create_folder' class='btn '><img src="includes/doc_attachments/playlist/icons/plus.png" style="width: 15px;height: 15px;"> Create Folder</button>
	    </form>
	    <form action='doc_files.php?parent_id=<?php echo $folder_id ?>' method='POST' enctype='multipart/form-data'>

	       <label style="display: inline-flex;margin-left: 860px;margin-bottom: -2px;margin-top: 25px;"><input class="form-control" type="file" name="file" required="" style="width:220px;margin-left:-60px;"></label>


		    <button  style="float:right; margin-bottom: -30px; border:gray solid 0.5px;float:right;margin:7px;margin-right:-126px;margin-top:25px;width:120px;"  name='upload_file' class='btn '><img src="includes/doc_attachments/playlist/icons/plus.png" style="width: 15px;height: 15px;"> upload File</button>
	    </form>

			<div style="display:inline-flex;">
			<div id="example"><i style=" margin-left:10px;margin-top:-30px;" class="fa fa-th fa-2x"></i></div></div>

			<script>

				$(document).ready(function() {
				    $("#example").popover({
				        placement: 'right',
				        html: 'true',
				         content:'<button class="btn" style=" padding:7px;padding-right:17px;color:blue;" type="button" data-toggle="modal" data-target="#edit" data-whatever="@mdo"><i class="fa fa-edit"> Edit this Folder</i></button> <br> <button style="padding:7px;margin-top:5px;color:red;" class="btn" type="button" data-toggle="modal" data-target="#delete" data-whatever="@mdo"><i class="fa fa-times"> Delete this Folder</i></button>',
				        
				    	});
					});  
			</script>


	<?php } ?>
        </div>
    <!-- start display playlists -->
    <?php 
    	if ($user_id != $userown_id) {
    		?><div  style="padding:1rem 1rem 1rem 4.5rem;min-width: 1185px;min-height:560px; background-color: #F1F1F1;padding-left:4rem;" class="card-body"><?php

    	} else {
    		?><div  style="padding:1rem 1rem 1rem 4.5rem;min-width: 1185px;min-height:470px; background-color: #F1F1F1;padding-left:4rem;" class="card-body">
    	<?php } ?>


		<?php 

		//get parent data
		$stmt = $con->prepare("SELECT * FROM folder WHERE  folder_id = $folder_id");
		$stmt->execute(array($user_id));
		$parent_data  = $stmt->fetch();
		$count = $stmt->rowCount();
		if ($count !=0) {
			$parent_name = $parent_data['folder_name'];
			$parent_parent_id = $parent_data['parent_id'];
		}




		//display folders
		    $stmt = $con->prepare("SELECT * FROM folder WHERE  parent_id = $folder_id");
			$stmt->execute(array($user_id));
			$folders   = $stmt->fetchAll();
			$folders_count = $stmt->rowCount();
			if ($folders_count) {
			?><h4 style="margin-left: 8px;color: rgba(0,0,0,0.55);">Folders</h4>
			<?php
			foreach ($folders as $key => $folder){
				$current_folder_id   = $folder['folder_id'];
				$parent_id   = $folder['parent_id'];
				$folder_name = $folder['folder_name'];
				$folder_time = $folder['folder_time'];
				$privacy     = $folder['privacy'];
            ?>
            	<div class="task" data-id="2" style="display:inline-flex;">
            		<a href="doc_files.php?parent_id=<?php echo $current_folder_id ?>" title="<?php echo $folder_name;?>" style="text-decoration:none;">
	            		<div class="card-header shadow" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;width:220px;height:50px; margin:5px;padding-top:rem; border-radius:6px;">
	            			<img src="includes/doc_attachments/folder/icons/folder.png" style="width: 26px;height: 26px;margin:14px;margin-top:8px;">
	            			<span style="margin-left:-10px; color:rgba(0,0,0,0.72);font-size: 20px;"><?php echo $folder_name;?></span>
	            		</div>
	            	</a>
	            </div>
            
		       
<?php 
	}
	}?>




		<?php 

		    $stmt = $con->prepare("SELECT * FROM file WHERE  parent_id = $folder_id");
			$stmt->execute(array($user_id));
			$files   = $stmt->fetchAll();
			$files_count = $stmt->rowCount();
			if ($files_count) {
			?>
			<h4 style="margin-left: 8px;color: rgba(0,0,0,0.55);">Files</h4>
			<p style="margin-left: 8px;color: rgba(0,0,0,0.55);">click on any file to download it.</p>
			<?php
			foreach ($files as $key => $onefile){
				$file_id    = $onefile['file_id'];
				$file       = $onefile['file'];
				$file_image = $onefile['file_image'];
				//$var = "fi";$var2="fi-ppt";
            ?>
        <div class="task" data-id="2" style="display:inline-flex;">
            <a href="includes/doc_attachments/folder/files/<?php echo $file; ?>" title="<?php echo $file;?>" download="" style="text-decoration:none; display: inline-flex;">
            	<div class="fi" style="margin:4px;">
	            	<div class="card-header" style="display:block;border: 1.5px;border-radius: 8px; width:200px; height:160px;margin:5px; margin-top:5px; background-image: url('includes/doc_attachments/folder/icons/<?php echo $file_image;?>'); background-repeat: no-repeat;background-size: 90% 90%;background-position:center;">
	            	</div>

	            	<div class="card-header shadow" style="display: inline-flex; margin-top: -10px;margin-bottom:2px;border: 1.5px;border-bottom-right-radius:8px;border-bottom-left-radius:8px; width:200px;height: 55px;margin-left:5px;">
	            		<h4 style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;margin: 8px;margin-top:14px; color:rgba(0,0,0,0.8);"><?php echo $file;?></h4>

	            	</div>
                </div>
           	   

        		</a>
        	</div>


		       
<?php 
	}
	}

	elseif($folders_count==0 && $files_count==0 && $user_id == $userown_id)
		{
			echo "<center style='margin-left:320px;margin-top:250px;margin-right:435px;margin-bottom:170px;color:rgba(0,0,0,0.6)'><h3>there are no Folders or Files yet!<h3><center>";
		}
	elseif($folders_count==0 && $files_count==0 && $user_id != $userown_id)
		{
			echo "<center style='margin-left:320px;margin-top:250px;margin-right:435px;margin-bottom:270px;color:rgba(0,0,0,0.6)'><h3>there are no Folders or Files yet!<h3><center>";
		}?>

      </div>
    </div>


    <?php 

    	if (isset($_POST['create_folder'])) {
    		$folder_name = htmlentities($_POST['folder_name']);
    		$privacy =1;
    		$parent_id =$folder_id;
    		if ($folder_name =='') {
	        	echo "<script>alert('please insert folder name !')</script>";
	        	echo "<script>window.open('doc_folders.php?parent_id=$parent_id','_self')</script>";	
    		}
    		else
    		{
				$insert = $con->prepare("INSERT into folder(folder_name,privacy,parent_id,user_id)values('$folder_name','$privacy','$parent_id','$userown_id')");
				$insert ->execute();                
			    
			    if($insert){
			          	 //echo "<script>alert('playlist added!')</script>";
			        echo "<script>window.open('doc_files.php?parent_id=$parent_id','_self')</script>";
			  	}
    		}
    	}


    	if (isset($_POST['update_folder'])) {
    		$folder_name = htmlentities($_POST['folder_name']);
    		$parent_id =$folder_id;

    		if ($folder_name =='') {
	        	echo "<script>alert('please insert folder name !')</script>";
	        	echo "<script>window.open('doc_files.php?parent_id=$parent_id','_self')</script>";	
    		}
    		else
    		{
				$insert = $con->prepare("UPDATE folder SET folder_name='$folder_name' WHERE folder_id='$parent_id' ");
				$insert ->execute();                
			    
			    if($insert){
			          	echo "<script>alert('Folder Updated')</script>";
			            echo "<script>window.open('doc_files.php?parent_id=$parent_parent_id','_self')</script>";
			  	}
    		}
    	}


    	//delete folder
	    if(isset($_POST['delete_folder'])){
	    	$parent_id =$folder_id;
	    	$delete = $con->prepare("DELETE FROM folder WHERE folder_id='$parent_id'") ;
			$delete->execute(); 
			if($delete){
				echo "<script>alert('A folder has been deleted!')</script>";
				echo "<script>window.open('doc_files.php?parent_id=$parent_parent_id','_self')</script>";
			}
			else
			{
		      	  	echo "<script>alert('Un Expicted error while deleting folder')</script>";
		        	echo "<script>window.open('doc_files.php?parent_id=$parent_parent_id','_self')</script>";
		        	exit();

			}

	    }

    	if (isset($_POST['upload_file'])) {
    		$file = $_FILES['file']['name'];
    		$file_tmp = $_FILES['file']['tmp_name'];
    		$file_image;
    		$parent_id =$folder_id;

    		$FileType = strtolower(pathinfo($file,PATHINFO_EXTENSION));
    		if ($file =='') {
	        	echo "<script>alert('please insert folder name !')</script>";
	        	echo "<script>window.open('doc_files.php?parent_id=$parent_id','_self')</script>";	
    		}
    		else
    		{
    			if ($FileType =='doc' || $FileType=='dot' || $FileType=='wbt' || $FileType=='docx') {
    				$file_image = "word.png";
    				move_uploaded_file($file_tmp,"includes/doc_attachments/folder/files/$file");
				    $insert = $con->prepare("INSERT into file(file,file_image,parent_id,user_id)values('$file','$file_image','$parent_id','$user_id')");
				    $insert ->execute();  
					if($insert){
				        //echo "<script>alert('file uploaded')</script>";
				        echo "<script>window.open('doc_files.php?parent_id=$parent_id','_self')</script>";
				  	}
				  	else
				  	{
				        echo "<script>alert('error while insert into data base!')</script>";
				        echo "<script>window.open('doc_files.php?parent_id=$parent_id','_self')</script>";
				  		
				  	}
    			}
    			elseif ($FileType =='xls' || $FileType=='xlt' || $FileType=='xlm') {
    				$file_image = "excel.png";
    				move_uploaded_file($file_tmp,"includes/doc_attachments/folder/files/$file");
				    $insert = $con->prepare("INSERT into file(file,file_image,parent_id,user_id)values('$file','$file_image','$parent_id','$user_id')");
				    $insert ->execute();  
					if($insert){
				        //echo "<script>alert('file uploaded')</script>";
				        echo "<script>window.open('doc_files.php?parent_id=$parent_id','_self')</script>";
				  	}
				  	else
				  	{
				        echo "<script>alert('error while insert into data base!')</script>";
				        echo "<script>window.open('doc_files.php?parent_id=$parent_id','_self')</script>";
				  		
				  	}
    			}
    			elseif ($FileType =='ppt' || $FileType=='pot' || $FileType=='pps' || $FileType=='pptx' || $FileType=='ppsx') {
    				$file_image = "powerpoint.png";
    				move_uploaded_file($file_tmp,"includes/doc_attachments/folder/files/$file");
				    $insert = $con->prepare("INSERT into file(file,file_image,parent_id,user_id)values('$file','$file_image','$parent_id','$user_id')");
				    $insert ->execute();  
					if($insert){
				        //echo "<script>alert('file uploaded')</script>";
				        echo "<script>window.open('doc_files.php?parent_id=$parent_id','_self')</script>";
				  	}
				  	else
				  	{
				        echo "<script>alert('error while insert into data base!')</script>";
				        echo "<script>window.open('doc_files.php?parent_id=$parent_id','_self')</script>";
				  		
				  	}

    			}
    			elseif ($FileType =='pdf') {
    				$file_image = "pdf.png";
    				move_uploaded_file($file_tmp,"includes/doc_attachments/folder/files/$file");
				    $insert = $con->prepare("INSERT into file(file,file_image,parent_id,user_id)values('$file','$file_image','$parent_id','$user_id')");
				    $insert ->execute();  
					if($insert){
				        //echo "<script>alert('file uploaded')</script>";
				        echo "<script>window.open('doc_files.php?parent_id=$parent_id','_self')</script>";
				  	}
				  	else
				  	{
				        echo "<script>alert('error while insert into data base!')</script>";
				        echo "<script>window.open('doc_files.php?parent_id=$parent_id','_self')</script>";
				  		
				  	}

    			}
    			else
    			{
    				$file_image = "unknownfile.png";
    				move_uploaded_file($file_tmp,"includes/doc_attachments/folder/files/$file");
				    $insert = $con->prepare("INSERT into file(file,file_image,parent_id,user_id)values('$file','$file_image','$parent_id','$user_id')");
				    $insert ->execute();  
					if($insert){
				        echo "<script>alert('file uploaded')</script>";
				        echo "<script>window.open('doc_files.php?parent_id=$parent_id','_self')</script>";
				  	}
				  	else
				  	{
				        echo "<script>alert('error while insert into data base!')</script>";
				        echo "<script>window.open('doc_files.php?parent_id=$parent_id','_self')</script>";
				  		
				  	}

    			}              
    		}
    	}

    ?>
<?php } ?>


	<!-- Start Delete Popup -->
	<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 100px;">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<center>
	      		<h4 class="modal-title" id="exampleModalLabel" style="display:inline-block;">Are you sure delete ' <?php echo $parent_name;?> '
	      		</h4>
	      	</center>
	        <button style="margin-top:-35px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">


	      	<form action='doc_files.php?parent_id=<?php echo $folder_id ?>' method='POST' enctype='multipart/form-data'>
	    	<center>
	    		<p style=" "><strong style="text-decoration: underline;">Hint:</strong> All Files and Folders in this Folder will be deleted too</p>
	    		<br>
				<span style="display:inline-flex;">
			            <button  style="border:gray solid 0.5px; margin-right: 50px;margin-left:50px; height: 35px;" name='delete_folder' class='btn btn-info'>Delete</butto>
			            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			    </span>
		       </span>
		    </center>
	        </form>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End Delete Popup -->

	<!-- Start Edit Popup -->
	<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 100px;">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	      	<center>
	      		<h4 class="modal-title" id="exampleModalLabel" style="display:inline-block;">Edit This Folder
	      		</h4>
	      	</center>
	        <button style="margin-top:-35px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">


	      	<form action='doc_files.php?parent_id=<?php echo $folder_id; ?>' method='POST' enctype='multipart/form-data'>
	    	<center>
	      		<span style="display:inline-flex;">
					<h4 style="margin-right: 32px;" >Folder Name</h4><input value="<?php echo $parent_name; ?>" maxlength="56" class="form-control" type="text" name="folder_name" required="" style="width:250px;">

				</span><br>
				<span style="display:inline-flex;">
			            <button  style="border:gray solid 0.5px; margin-right: 50px;margin-left:140px; height: 35px;" name='update_folder' class='btn btn-info'>Save</butto>
			            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			    </span>
		       </span>
		    </center>
	        </form>	        
	      </div>
	    </div>
	  </div>
	</div>
	<!-- End Edit Popup -->



	<?php
	include 'includes/templates/footer.php';
?>
