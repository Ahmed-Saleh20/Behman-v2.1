<?php
	session_start();
	$noNavbar = ''; 
	include("initialize.php");
	if(!isset($_SESSION['user_email'])){
		header("location: index.php");
	}else{ 
?>

<?php



	$chat_id = isset($_GET['chat_id']) && is_numeric($_GET['chat_id']) ? intval($_GET['chat_id']) : 0 ;
		$private = $con->prepare("SELECT * from coming_private_chat where id='$chat_id' ");
		$private ->execute();
		$row_chat = $private ->fetch();	
		$count = $private->rowCount();
		if($count > 0 ){
			$chat_id = $row_chat['id'];
			$this_doc_id = $row_chat['doc_id'];
			$this_user_id = $row_chat['user_id'];
			$day_char = $row_chat['day_char'];

			$final_day = $row_chat['final_day'];
			$final_month = $row_chat['final_month'];
			$final_year = $row_chat['final_year'];
			$start_chat = $row_chat['start_chat'];
			$start_minutes = $row_chat['start_minutes'];
			$am_pm = $row_chat['am_pm'];


			$was_booked_on = $row_chat['was_booked_on'];
			$duration = $row_chat['duration'];
			$cost = $row_chat['cost'];







	//$user_id = isset($_GET['doc_id']) && is_numeric($_GET['doc_id']) ? intval($_GET['doc_id']) : 0 ;
			//get doctor data
			$stmt = $con->prepare("SELECT * FROM users WHERE user_id = $this_doc_id AND type = '1'");
			$stmt->execute();
			$row = $stmt->fetch();
			$count = $stmt->rowCount();
				$id = $row['user_id'];
				$name = $row['user_name'];
				$f_name = $row['f_name'];
				$l_name = $row['l_name'];
				$user_image = $row['user_image'];

			//get patient(user) data
			$stmt = $con->prepare("SELECT * FROM users WHERE user_id = $this_user_id ");
			$stmt->execute();
			$row = $stmt->fetch();
			$id_u = $row['user_id'];
			$name_u = $row['user_name'];
			$f_name_u = $row['f_name'];
			$l_name_u= $row['l_name'];
			$user_image_u = $row['user_image'];
				}

				/* Check IF User Is Owner User */
				$user = $_SESSION['user_email'];
				$get_user  = $con->prepare("SELECT * from users where user_email='$user'");
				$get_user  ->execute();
				$row = $get_user  ->fetch();	
				$userown_id = $row['user_id'];
				$user_name = $row['user_name'];
				$type = $row['type'];

				$_SESSION['doc_id'] = $id;
				$_SESSION['user_id'] = $id_u;
				$_SESSION['doc_name'] = $name;
				$_SESSION['user_name'] = $name_u;
				$_SESSION['chat_id'] = $chat_id;
				$_SESSION['userown_id'] = $userown_id;



?>

	<link rel="stylesheet" href="private_chat/style.css" />
	<link rel="stylesheet" type="text/css" href="mystylesheet.css">
    <center>
      <div id="alert" class="alert alert-warning alert-dismissible col-lg-12 nowtext" style="margin-left: 335px;margin-right: 20px;width: 50%;background-color: yellow;">
        <h5 style="margin-top: -10px;"><i class='fas fa-exclamation-triangle' style='font-size:28px;color:red'></i>&nbsp;
 Alert </h5>

 		<p class="h5" id="text1">this chat not open yet</p>
 		<div style="display: inline-flex;"> 		
 			<p class="h5" style="margin-right: 10px;">will start on </p>
 			<p class="h5" id="text2" style="color: red;font-weight: bold;"></p>
 		</div>


      </div>
    </center><br>
<div class="container">
	<div class="form-group">
		<div style="width: 800px;height: 50px;margin-left: 170px; background-color: #d7fcd7;border-radius: 5px;border-bottom-left-radius: 0px;border-bottom-right-radius: 0px;margin-top: -15px;padding-bottom: 10px;display: inline-flex;">
			
			<?php if ($id_u == $userown_id) { ?>
				<a href='doc_profile.php?u_id=<?php echo $this_doc_id;?>' title="view profile" style="margin-left:5px;margin-top: 5px; text-decoration: none;"><img 
					src='includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.png'; } ?>' 
					            	class='img-circle'
					            	alt='Profile' 	 
					            	width='40px' 
					            	height='40px' 
				 /></a>
				 <a title='view profile' style='margin-left: 21px;' href='doc_profile.php?u_id=<?php echo $this_doc_id;?>'><?php echo "<h5 style='margin-left:-13px;font-weight:bold;color:black;'>Dr: $f_name $l_name</h5>";?></a>
				        <span id="countdown-11" style="color: red;font-weight: bold;float: right;margin-left: 400px;margin-top: 10px;"></span>
			<?php } else{ ?>
				<a title="you can not see this user profile" style="margin-left:5px;margin-top: 5px; text-decoration: none;"><img 
					src='includes/images/users/<?php if(!empty($user_image_u)){ echo $user_image_u; }else{ echo 'default.png'; } ?>' 
					            	class='img-circle'
					            	alt='Profile' 	 
					            	width='40px' 
					            	height='40px' 
				 /></a>
				        <span  id="countdown-11" class="" style="color: red;font-weight: bold;float: right;margin-left: 530px;margin-top: 10px;"></span>
			<?php } ?>


	    </div>
	</div>

		<div class="chat_wrapper" style="margin-top: -15px;">	
			<div id="abc"></div>
			<div id="chat" style="height:440px;overflow:auto;border:1px solid #b3b3b3;padding:10px;border-top:none; border-radius: 5px;border-top-left-radius: 0px;border-top-right-radius: 0px; margin-top: 0px;"></div>
			<iframe hidden="true" name="content" style="">
            </iframe>
			<form action="private_chat/handlers/send_message.php" method="POST" id="messageFrm" enctype='multipart/form-data' style="display: inline-flex;"  target="content">



				<textarea id="message_textarea" name="message" cols="30" rows="2" class="textarea form-control chatlimit" placeholder="Write message" style="width: 717px;margin-right: 10px;border-radius: 5px;"></textarea>

				<input type="hidden" name="userown_id" value="<?php echo $userown_id; ?>">
				<input type="hidden" name="chat_id" value="<?php echo $chat_id; ?>">
				<button id="send_message" name="send_message" title="Send" class="form-control chatlimit" style="height: 70px;width: 70px; margin-top: 10px;background-color: #8ff78f;border: none;border-radius: 5px;"><i style="" class='fa fa-paper-plane fa-3x' aria-hidden='true'></i></button>

			</form>
		</div>


		
    </div>
<?php

    // $target = mktime(4, 54, 0, 6, 30, 2020) ;//set marriage date

    // $today = time () ;

    // $difference =($target-$today) ;

    // $month =date('m',$difference) ;
    // $days =date('d',$difference) ;
    // $hours =date('h',$difference) ;

    // print $month." month".$days." days".$hours."hours left";

    ?>
    <span  id="countdown-1" hidden="">5</span>
  	<script>
	
	//today date details
	  var da = new Date();

	  var d_today =  da.getDate();
	  var mo_today = da.getMonth()+1;
	  var y_today =  da.getFullYear();
	  var mi_today = da.getMinutes();

	  if (da.getHours() > 12) {
	  	var h_today = (da.getHours())-12;
	  	var am_today = 'PM';
	  }
	  else{
	  	var h_today = da.getHours();
	  	var am_today = 'AM';
	  }


	//chat date details
    var d_chat = "<?php echo $final_day; ?>";
    var mo_chat = "<?php echo $final_month; ?>";
    var y_chat = "<?php echo $final_year; ?>";
    var h_chat = "<?php echo $start_chat; ?>";
    var mi_chat = "<?php echo $start_minutes; ?>";
    var am_chat = "<?php echo $am_pm; ?>";
    var duration_chat = "<?php echo $duration; ?>";


    if (y_today == y_chat) {
    	if (mo_today == mo_chat) {
    		if (d_today == d_chat) {
    			if (h_today == h_chat) {
    				if (mi_today == mi_chat) {
    					document.getElementById("alert").classList.add("nowtext");
    					document.getElementById("message_textarea").classList.remove("chatlimit");
    					document.getElementById("send_message").classList.remove("chatlimit");
    				}


    				
    				else if (mi_today < mi_chat){
    			    	 if (mi_chat == 0) {
    	document.getElementById("text2").innerHTML = d_chat+'/'+mo_chat+'/'+y_chat+' at '+h_chat+':'+mi_chat+mi_chat+' '+am_chat;}
    					else{
    	document.getElementById("text2").innerHTML = d_chat+'/'+mo_chat+'/'+y_chat+' at '+h_chat+':'+mi_chat+' '+am_chat;
    	}
    	document.getElementById("alert").classList.remove("nowtext");
    	document.getElementById("countdown-11").classList.add("nowtext");
    				}

    			    else{
    			    	 if (mi_chat == 0) {
    	document.getElementById("text2").innerHTML = d_chat+'/'+mo_chat+'/'+y_chat+' at '+h_chat+':'+mi_chat+mi_chat+' '+am_chat;}
    					else{
    	document.getElementById("text2").innerHTML = d_chat+'/'+mo_chat+'/'+y_chat+' at '+h_chat+':'+mi_chat+' '+am_chat;
    	}
    	document.getElementById("alert").classList.remove("nowtext");
    	document.getElementById("countdown-11").classList.add("nowtext");
    }
    			}
    			    else{
    			    	 if (mi_chat == 0) {
    	document.getElementById("text2").innerHTML = d_chat+'/'+mo_chat+'/'+y_chat+' at '+h_chat+':'+mi_chat+mi_chat+' '+am_chat;}
    					else{
    	document.getElementById("text2").innerHTML = d_chat+'/'+mo_chat+'/'+y_chat+' at '+h_chat+':'+mi_chat+' '+am_chat;
    	}
    	document.getElementById("alert").classList.remove("nowtext");
    	document.getElementById("countdown-11").classList.add("nowtext");
    }
    		}
    			    else{
    			    	 if (mi_chat == 0) {
    	document.getElementById("text2").innerHTML = d_chat+'/'+mo_chat+'/'+y_chat+' at '+h_chat+':'+mi_chat+mi_chat+' '+am_chat;}
    					else{
    	document.getElementById("text2").innerHTML = d_chat+'/'+mo_chat+'/'+y_chat+' at '+h_chat+':'+mi_chat+' '+am_chat;
    	}
    	document.getElementById("alert").classList.remove("nowtext");
    	document.getElementById("countdown-11").classList.add("nowtext");
    }
    	}
    			    else{
    			    	 if (mi_chat == 0) {
    	document.getElementById("text2").innerHTML = d_chat+'/'+mo_chat+'/'+y_chat+' at '+h_chat+':'+mi_chat+mi_chat+' '+am_chat;}
    					else{
    	document.getElementById("text2").innerHTML = d_chat+'/'+mo_chat+'/'+y_chat+' at '+h_chat+':'+mi_chat+' '+am_chat;
    	}
    	document.getElementById("alert").classList.remove("nowtext");
    	document.getElementById("countdown-11").classList.add("nowtext");
    }
    }
    			    else{
    			    	 if (mi_chat == 0) {
    	document.getElementById("text2").innerHTML = d_chat+'/'+mo_chat+'/'+y_chat+' at '+h_chat+':'+mi_chat+mi_chat+' '+am_chat;}
    					else{
    	document.getElementById("text2").innerHTML = d_chat+'/'+mo_chat+'/'+y_chat+' at '+h_chat+':'+mi_chat+' '+am_chat;
    	}
    	document.getElementById("alert").classList.remove("nowtext");
    	document.getElementById("countdown-11").classList.add("nowtext");
    }
	</script>
<script type="text/javascript">
	function timerfun(){
    // Initialize clock countdowns by using the total seconds in the elements tag
    secs       = parseInt(document.getElementById('countdown-1').innerHTML,10);
    setTimeout("countdown('countdown-1',"+secs+")", 1000);
    // secs       = parseInt(document.getElementById('countdown-2').innerHTML,10);
    // setTimeout("countdown('countdown-2',"+secs+")", 1000);

    /**
     * Countdown function
     * Clock count downs to 0:00 then hides the element holding the clock
     * @param id Element ID of clock placeholder
     * @param timer Total seconds to display clock
     */
    function countdown(id, timer){
        timer--;
        minRemain  = Math.floor(timer / 60);
        secsRemain = new String(timer - (minRemain * 60));
        // Pad the string with leading 0 if less than 2 chars long
        if (secsRemain.length < 2) {
            secsRemain = '0' + secsRemain;
        }

        // String format the remaining time
        clock      = minRemain + ":" + secsRemain;
        document.getElementById("countdown-11").innerHTML = 'this chat will close after '+clock;
        if ( timer > 0 ) {
            // Time still remains, call this function again in 1 sec
            setTimeout("countdown('" + id + "'," + timer + ")", 1000);
        } else {
            // Time is out! Hide the countdown
            document.getElementById(id).style.display = 'none';
            window.open("http://localhost/Behman-v2.1/f/home.php ?>","_self");

        }

    }}
</script>
<?php

 ?>
	<script>
		LoadChat();
		setInterval(function(){
		
				LoadChat();
		
		}, 1000);
		function LoadChat()
		{
			$.post('private_chat/handlers/messages.php?action=getMessages', function(response){
				
				var scrollpos = $('#chat').scrollTop();
				var scrollpos = parseInt(scrollpos) + 520;
				var scrollHeight = $('#chat').prop('scrollHeight');
				$('#chat').html(response);
				if( scrollpos < scrollHeight ){
					
				}else{
					$('#chat').scrollTop( $('#chat').prop('scrollHeight') );
				}
			});
		}
		
		// $('.textarea').keyup(function(e){
		// 	if( e.which == 13 ){
		// 		$('form').submit();
		// 	}
		// });
		// $('form').submit(function(){
		// 	var message = $('.textarea').val();
		// 	$.post('handlers/messages.php?action=sendMessage&message='+message, function(response){
		// 		if( response==1 ){
		// 			LoadChat();
		// 			document.getElementById('messageFrm').reset();
		// 		}
		// 	});
		// 	return false;
		// });
	</script>

	<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>



<?php }?>
	<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>

	<?php

	include 'includes/templates/footer.php';
?>