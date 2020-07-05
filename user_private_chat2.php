<?php
  session_start();
  $pageTitle = "Profile" ; 
  $noNavbar = '';
  include("connectDB.php");

  if(!isset($_SESSION['user_email'])){
    header("location: index.php");
  }else{ 
?>



<?php

  $user_id = isset($_GET['u_id']) && is_numeric($_GET['u_id']) ? intval($_GET['u_id']) : 0 ;

  $stmt = $con->prepare("SELECT * FROM users WHERE user_id = ? AND type = '1'");
  $stmt->execute(array($user_id));
  $row = $stmt->fetch();
  $count = $stmt->rowCount();

  if($count > 0 ){
    $id = $row['user_id'];
    $name = $row['user_name'];
    $f_name = $row['f_name'];
    $l_name = $row['l_name'];
    $describe_user = $row['describe_user'];
    $gender = $row['user_gender'];
    $register_date = $row['user_reg_date'];
    $user_country = $row['user_country'];
    $Relationship_status = $row['Relationship'];
    $user_birthday = $row['user_birthday'];
    $user_image = $row['user_image'];
    $user_cover = $row['user_cover'];
    $private_chat = $row['private_chat'];
  

    /* Check IF User Is Owner User */
    $user = $_SESSION['user_email'];
    $get_user  = $con->prepare("SELECT * from users where user_email='$user'");
    $get_user  ->execute();
    $row = $get_user  ->fetch();  
    $userown_id = $row['user_id'];
    $user_name = $row['user_name'];
    $user_f_name = $row['f_name'];
    $type = $row['type'];
?>

<?php 
    if(isset($_POST['book_data'])){
      $day_id = htmlentities($_POST['final_day_id']);
      $cost_id = htmlentities($_POST['final_cost_id']);
      $credit_card = htmlentities($_POST['finial_credit']);
      $doc_id = htmlentities($_POST['doc_id']);
      $final_day = htmlentities($_POST['final_day']);
      $final_month = htmlentities($_POST['final_month']);
      $final_year = htmlentities($_POST['final_year']);
      $target_day = (htmlentities($_POST['target_day']));


      $private_chat = 1;
      $update1 = $con->prepare("UPDATE users SET private_chat ='$private_chat', credit_card='$credit_card' WHERE user_id='$userown_id'");
      $update1->execute();

        // get selected day data
      $stmt = $con->prepare("SELECT * FROM pctt WHERE id = $day_id ");
      $stmt->execute();
      $row = $stmt->fetch();
      $count = $stmt->rowCount();
      if($count > 0 ){
        $day = $row['day'];
        $day_char = $row['day_char'];
        $available_from = $row['available_from'];
        $available_from2 = $available_from;
        $available_to = $row['available_to'];
        $last_book = $row['last_book'];
        $last_book2 = $last_book;
        $from_am_pm = $row['from_am_pm'];
        $to_am_pm = $row['to_am_pm'];
        if ($from_am_pm == 1) {
          $start = "AM";
        }
        else{
          $start = "PM";
        }

        if ($to_am_pm == 1) {
          $end = "AM";
        }
        else{
          $end = "PM";
        }
      }


      $target_day_arr = array();
      $final_day2 = 100;
      for($x = $target_day,$y=0; $y <7; $y++,$x++) {
        if ($y == 0) {
          $x++;
        }
        $target_day_arr[$y]=$x;
        if ($x == 7) {
          $x =1;
        }
      }
      for ($i=0; $i <7 ; $i++) { 
        if ($target_day_arr[$i] == $day) {
            $final_day2 = ($final_day + $i);
        }
      }





      // get book cost and limit
      $stmt = $con->prepare("SELECT * FROM booked_chat WHERE id = $cost_id ");
      $stmt->execute();
      $row = $stmt->fetch();
      $count = $stmt->rowCount();
      if($count > 0 ){
        $cost = $row['cost'];
        $chat_time = $row['chat_time'];
      }
      $temp_hour =$last_book+$chat_time;
      if ($temp_hour >= 60) {
        if($last_book != 0){
        $available_from = $available_from +1;
        $start_minutes = 0;
        $last_book = $temp_hour - 60 ;
      }
        else{
          $available_from = $available_from +1;
          $last_book =0;
        }
      }
      else{
        $last_book = $temp_hour;
      }
      $end_chat = 
      $update2 = $con->prepare("UPDATE pctt SET available_from ='$available_from', last_book='$last_book' WHERE id='$day_id'");
      $update2->execute();
       ?>

  <?php

  if ($update1 && $update2) {

    $insert = $con->prepare("INSERT into coming_private_chat(doc_id,user_id,day_char,final_day,final_month,final_year,cost,duration,start_chat,start_minutes,am_pm,pm_am)values('$user_id','$userown_id','$day_char','$final_day2','$final_month','$final_year','$cost','$chat_time','$available_from2','$last_book2','$start','$end')");
   $insert->execute();
         echo "<script>alert('Book Done Succussflly')</script>";
                  echo "<script>alert(<?php echo $day; ?>)</script>";

        echo "<script>window.open('user_profile.php?u_id=$userown_id','_self')</script>";

  }

   } ?>

<?php }else{
      echo "<script>alert('There Is No ID Exist ! $day')</script>";
        echo "<script>window.open('home.php','_self')</script>";
} ?>

<?php } ?>

