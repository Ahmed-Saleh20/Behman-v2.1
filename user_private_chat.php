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

  $stmt = $con->prepare("SELECT * FROM users WHERE user_id = ? AND GroupID = '2'");
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
    $type = $row['GroupID'];
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- my style sheet -->
  <link rel="stylesheet" href="dist/css/mystylesheet.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed"  style="background-color: #ebebeb;">
<div class="wrapper">

  <!-- Content Wrapper. Contains page content -->
  <div >
    <!-- Content Header (Page header) -->
 <div class="col-lg-12 row" style="margin-top: 20px;margin-bottom: 10px;">
    <div class="" style="margin-left: 20px;">
    <a href="home.php" style="color: black;"><i title="Home" class="fa fa-home fa-2x" aria-hidden="true"></i></a>
    </div>
    <div class="col-lg-3" style="margin-left: 15px;margin-right: -70px;">
    <a href="user_profile.php?u_id=<?php echo $userown_id; ?>" style="color: black;"><i title="Your Profile" class="fa fa-user-circle fa-2x" aria-hidden="true"></i></a>
    </div>
</div>

    <!-- /.content-header -->

    <!-- Main content -->

    <div class="col-lg-12" style="">
            <div class="card" style="margin-right: 10px;margin-left: 10px;">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <div class="direct-chat-msg" style="float: left;">
                    <!-- /.direct-chat-infos -->
                    <a href="doc_profile.php?u_id=<?php echo $user_id; ?>">
                    <img  class="direct-chat-img img-shadow" src='includes/images/users/<?php if(!empty($user_image)){ echo $user_image; }else{ echo 'default.png'; } ?>'></a>
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                      Hi <?php echo $user_f_name; ?>, I'm Doctor <?php echo $f_name; ?> and this my timetable next days
                    </div>
                    <!-- /.direct-chat-text -->


                  </div>

                </div>
              </div>

              <div class="card-body">
                <h6> select day of chat from available days</h6>

<ul style="margin-left:-40px;">

                <?php 
                  // get available days
                $stmt = $con->prepare("SELECT * FROM pctt WHERE doc_id = $user_id ");
                $stmt->execute(array($user_id));
                $all_days = $stmt->fetchAll();
                $count = $stmt->rowCount();

                if($count > 0 ){
                foreach ($all_days as $key => $row){
                  $current_day_id = $row['id'];
                  $day = $row['day'];
                  $day_char = $row['day_char'];
                  $availability = $row['availability'];
                  $available_from = $row['available_from'];
                  $available_to = $row['available_to'];
                  $last_book = $row['last_book'];
                  $from_am_pm = $row['from_am_pm'];
                  $to_am_pm = $row['to_am_pm'];

                  if ($from_am_pm == 1) {
                    $temp = 1;
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

                 ?>



                 <?php 

                    if ($day == 1) {
                        if($availability == 1) { ?>
                  <li class="daystyle">
                    <input type="hidden" name="day_id1" id="day_id1" value="<?php echo $current_day_id; ?>">

                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" name='check' id="Check1" onclick="displaychatlimit(this,'day_id1')" onchange="checkAll(this)">
                      <label for="Check1"><?php echo $day_char;?>:</label> 
                    </div>
                    <small class="badge badge-success"><i class="far fa-clock"></i>available</small>
                    <span style="margin-left: 50px;">&nbsp;From <strong>&nbsp;&nbsp;<?php echo $available_from; ?></strong>&nbsp; <?php echo $start; ?>&nbsp; To<strong>&nbsp;&nbsp;<?php echo $available_to; ?></strong>&nbsp; <?php echo $end; ?></span>
                  </li>
                       <?php } 
                      if($availability == 0){ ?>
                  <li  class="done daystyle">
                    <!-- drag handle -->
<!--                     <span class="handle ui-sortable-handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span> -->
                    <!-- checkbox -->
                    <div class="icheck-primary d-inline ml-2">
                      <i style="margin-right: 7px;margin-left: 4px;" class="fa fa-window-close" aria-hidden="true"></i>
                    </div>
                    <!-- todo text -->
                    <span class="text" style="text-decoration:line-through;"><?php echo $day_char;?>:</span>
                    <!-- Emphasis label -->
                    <small style="background: #adb5bd!important;" class="badge badge-success"></i> Not avalaible</small>
                    <!-- General tools such as edit or delete-->
                  </li>
                       <?php }
                    }                  
                    if ($day == 2) {
                        if($availability == 1) { ?>
                  <li class="daystyle">
                    <input type="hidden" name="day_id2" id="day_id2" value="<?php echo $current_day_id; ?>">
<!--                     <span class="handle ui-sortable-handle">
                          <i class="fas fa-ellipsis-v"></i>
                          <i class="fas fa-ellipsis-v"></i>
                    </span> -->
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" name='check' id="Check2" onclick="displaychatlimit(this,'day_id2')" onchange="checkAll(this)">
                      <label for="Check2"><?php echo $day_char;?>:</label> 
                    </div>
                    <small class="badge badge-success"><i class="far fa-clock"></i>available</small>
                    <span style="margin-left: 50px;">&nbsp;From <strong>&nbsp;&nbsp;<?php echo $available_from; ?></strong>&nbsp; <?php echo $start; ?>&nbsp; To<strong>&nbsp;&nbsp;<?php echo $available_to; ?></strong>&nbsp; <?php echo $end; ?></span>
                  </li>
                       <?php } 
                        if($availability == 0){ ?>
                  <li  class="done daystyle">
                    <!-- drag handle -->
<!--                     <span class="handle ui-sortable-handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span> -->
                    <!-- checkbox -->
                    <div class="icheck-primary d-inline ml-2">
                      <i style="margin-right: 7px;margin-left: 4px;" class="fa fa-window-close" aria-hidden="true"></i>
                    </div>
                    <!-- todo text -->
                    <span class="text" style="text-decoration:line-through;"><?php echo $day_char;?>:</span>
                    <!-- Emphasis label -->
                    <small style="background: #adb5bd!important;" class="badge badge-success"></i> Not avalaible</small>
                    <!-- General tools such as edit or delete-->
                  </li>
                       <?php }
                    }                  
                    if ($day == 3) {
                        if($availability == 1) { ?>
                  <li class="daystyle">
                    <input type="hidden" name="day_id3" id="day_id3" value="<?php echo $current_day_id; ?>">
<!--                     <span class="handle ui-sortable-handle">
                          <i class="fas fa-ellipsis-v"></i>
                          <i class="fas fa-ellipsis-v"></i>
                    </span> -->
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" name='check' id="Check3" onclick="displaychatlimit(this,'day_id3')" onchange="checkAll(this)">
                      <label for="Check3"><?php echo $day_char;?>:</label> 
                    </div>
                    <small class="badge badge-success"><i class="far fa-clock"></i>available</small>
                    <span style="margin-left: 50px;">&nbsp;From <strong>&nbsp;&nbsp;<?php echo $available_from; ?></strong>&nbsp; <?php echo $start; ?>&nbsp; To<strong>&nbsp;&nbsp;<?php echo $available_to; ?></strong>&nbsp; <?php echo $end; ?></span>
                  </li>
                       <?php } 
                        if($availability == 0){ ?>
                  <li  class="done daystyle">
                    <!-- drag handle -->
<!--                     <span class="handle ui-sortable-handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span> -->
                    <!-- checkbox -->
                    <div class="icheck-primary d-inline ml-2">
                      <i style="margin-right: 7px;margin-left: 4px;" class="fa fa-window-close" aria-hidden="true"></i>
                    </div>
                    <!-- todo text -->
                    <span class="text" style="text-decoration:line-through;"><?php echo $day_char;?>:</span>
                    <!-- Emphasis label -->
                    <small style="background: #adb5bd!important;" class="badge badge-success"></i> Not avalaible</small>
                    <!-- General tools such as edit or delete-->
                  </li>
                       <?php }
                    }                  
                    if ($day == 4) {
                        if($availability == 1) { ?>
                  <li class="daystyle">
                    <input type="hidden" name="day_id4" id="day_id4" value="<?php echo $current_day_id; ?>">
<!--                     <span class="handle ui-sortable-handle">
                          <i class="fas fa-ellipsis-v"></i>
                          <i class="fas fa-ellipsis-v"></i>
                    </span> -->
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" name='check' id="Check4" onclick="displaychatlimit(this,'day_id4')" onchange="checkAll(this)">
                      <label for="Check4"><?php echo $day_char;?>:</label> 
                    </div>
                    <small class="badge badge-success"><i class="far fa-clock"></i>available</small>
                    <span style="margin-left: 50px;">&nbsp;From <strong>&nbsp;&nbsp;<?php echo $available_from; ?></strong>&nbsp; <?php echo $start; ?>&nbsp; To<strong>&nbsp;&nbsp;<?php echo $available_to; ?></strong>&nbsp; <?php echo $end; ?></span>
                  </li>
                       <?php } 
                        if($availability == 0){ ?>
                  <li  class="done daystyle">
                    <!-- drag handle -->
<!--                     <span class="handle ui-sortable-handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span> -->
                    <!-- checkbox -->
                    <div class="icheck-primary d-inline ml-2">
                      <i style="margin-right: 7px;margin-left: 4px;" class="fa fa-window-close" aria-hidden="true"></i>
                    </div>
                    <!-- todo text -->
                    <span class="text" style="text-decoration:line-through;"><?php echo $day_char;?>:</span>
                    <!-- Emphasis label -->
                    <small style="background: #adb5bd!important;" class="badge badge-success"></i> Not avalaible</small>
                    <!-- General tools such as edit or delete-->
                  </li>
                       <?php }
                    }                 
                    if ($day == 5) {
                        if($availability == 1) { ?>
                  <li class="daystyle">
                    <input type="hidden" name="day_id5" id="day_id5" value="<?php echo $current_day_id; ?>">
<!--                     <span class="handle ui-sortable-handle">
                          <i class="fas fa-ellipsis-v"></i>
                          <i class="fas fa-ellipsis-v"></i>
                    </span> -->
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" name='check' id="Check5" onclick="displaychatlimit(this,'day_id5')" onchange="checkAll(this)">
                      <label for="Check5"><?php echo $day_char;?>:</label> 
                    </div>
                    <small class="badge badge-success"><i class="far fa-clock"></i>available</small>
                    <span style="margin-left: 50px;">&nbsp;From <strong>&nbsp;&nbsp;<?php echo $available_from; ?></strong>&nbsp; <?php echo $start; ?>&nbsp; To<strong>&nbsp;&nbsp;<?php echo $available_to; ?></strong>&nbsp; <?php echo $end; ?></span>
                  </li>
                       <?php } 
                        if($availability == 0){ ?>
                  <li  class="done daystyle">
                    <!-- drag handle -->
<!--                     <span class="handle ui-sortable-handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span> -->
                    <!-- checkbox -->
                    <div class="icheck-primary d-inline ml-2">
                      <i style="margin-right: 7px;margin-left: 4px;" class="fa fa-window-close" aria-hidden="true"></i>
                    </div>
                    <!-- todo text -->
                    <span class="text" style="text-decoration:line-through;"><?php echo $day_char;?>:</span>
                    <!-- Emphasis label -->
                    <small style="background: #adb5bd!important;" class="badge badge-success"></i> Not avalaible</small>
                    <!-- General tools such as edit or delete-->
                  </li>
                       <?php }
                    }                  
                    if ($day == 6) {
                        if($availability == 1) { ?>
                  <li class="daystyle">
                    <input type="hidden" name="day_id6" id="day_id6" value="<?php echo $current_day_id; ?>">
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" name='check' id="Check6" onclick="displaychatlimit(this,'day_id6')" onchange="checkAll(this)">
                      <label for="Check6"><?php echo $day_char;?>:</label> 
                    </div>
                    <small class="badge badge-success"><i class="far fa-clock"></i>available</small>
                    <span style="margin-left: 50px;">&nbsp;From <strong>&nbsp;&nbsp;<?php echo $available_from; ?></strong>&nbsp; <?php echo $start; ?>&nbsp; To<strong>&nbsp;&nbsp;<?php echo $available_to; ?></strong>&nbsp; <?php echo $end; ?></span>
                  </li>
                       <?php } 
                        if($availability == 0){ ?>
                  <li  class="done daystyle">
                    <!-- drag handle -->
<!--                     <span class="handle ui-sortable-handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span> -->
                    <!-- checkbox -->
                    <div class="icheck-primary d-inline ml-2">
                      <i style="margin-right: 7px;margin-left: 4px;" class="fa fa-window-close" aria-hidden="true"></i>
                    </div>
                    <!-- todo text -->
                    <span class="text" style="text-decoration:line-through;"><?php echo $day_char;?>:</span>
                    <!-- Emphasis label -->
                    <small style="background: #adb5bd!important;" class="badge badge-success"></i> Not avalaible</small>
                    <!-- General tools such as edit or delete-->
                  </li>
                       <?php }
                    }                 
                    if ($day == 7) {
                        if($availability == 1) { ?>
                  <li class="daystyle">
                    <input type="hidden" name="day_id7" id="day_id7" value="<?php echo $current_day_id; ?>">
<!--                     <span class="handle ui-sortable-handle">
                          <i class="fas fa-ellipsis-v"></i>
                          <i class="fas fa-ellipsis-v"></i>
                    </span> -->
                    <div class="icheck-primary d-inline ml-2">
                      <input type="checkbox" name='check' id="Check7" onclick="displaychatlimit(this,'day_id7')" onchange="checkAll(this)">
                      <label for="Check7"><?php echo $day_char;?>:</label> 
                    </div>
                    <small class="badge badge-success"><i class="far fa-clock"></i>available</small>
                    <span style="margin-left: 50px;">&nbsp;From <strong>&nbsp;&nbsp;<?php echo $available_from; ?></strong>&nbsp; <?php echo $start; ?>&nbsp; To<strong>&nbsp;&nbsp;<?php echo $available_to; ?></strong>&nbsp; <?php echo $end; ?></span>
                  </li>
                       <?php } 
                        if($availability == 0){ ?>
                  <li  class="done daystyle">
                    <!-- drag handle -->
<!--                     <span class="handle ui-sortable-handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span> -->
                    <!-- checkbox -->
                    <div class="icheck-primary d-inline ml-2">
                      <i style="margin-right: 7px;margin-left: 4px;" class="fa fa-window-close" aria-hidden="true"></i>
                    </div>
                    <!-- todo text -->
                    <span class="text" style="text-decoration:line-through;"><?php echo $day_char;?>:</span>
                    <!-- Emphasis label -->
                    <small style="background: #adb5bd!important;" class="badge badge-success"></i> Not avalaible</small>
                    <!-- General tools such as edit or delete-->
                  </li>
                       <?php }
                    }
                 ?>





     <?php     }} ?>           
  </ul>
              </div>
            </div>
    </div>



    <div id="" class="col-lg-6 ">
      <div class="card" style="margin-right: 10px;margin-left: 10px;">
        <div class="card-header border-0">
          <div class="d-flex justify-content-between">
                <div class="col-lg-8 col-6">
                  <div class="col-lg-12 col-12" style="margin-top: ;">
                  <p >Please Enter your Credit Card Befor booking</p>
                  <input id="current_credit" type="text" name="my_credit_card" oninput="document.getElementById('finial_credit').value = this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="14" required="" class="form-control col-lg-8" placeholder="Credit Card">
                 </div>
                </div>

                <div class="col-lg-6 col-4">
                 <div class="col-lg-6 col-12" style="">
                  <figure>
                    <figcaption class="test">
                    <img style="margin-top: 5px;" src="dist/img/arrow.png" alt="" width="50" height="50">
                    </figcaption>
                  </figure>
                 </div>
                </div>
          </div>
        </div>
    </div>

    </div>
    <!-- select limit of chat -->
    <div id="time" class="col-lg-12 chatlimit">

            <div class="card" style="margin-right: 10px;margin-left: 10px;">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title" id="nowtext">Select day from above first</h3>
                </div>
              </div>
              <div class="card-body">

                <section class="content">
                  <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row" style="">

<?php 
                  // cost and chatelimit
                $stmt = $con->prepare("SELECT * FROM booked_chat WHERE doc_id = $user_id ");
                $stmt->execute(array($user_id));
                $all_costs = $stmt->fetchAll();
                $count = $stmt->rowCount();

                if($count > 0 ){
                foreach ($all_costs as $key => $row){
                  $cost_id = $row['id'];
                  $number = $row['chat_number'];
                  $cost = $row['cost'];
                  $chat_time = $row['chat_time'];
?>
                 <?php  if ($number == 1) { ?>
                      <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                          <div class="inner">
                            <h3><?php echo $cost; ?>$</h3>
                            <h5>for</h5>
                            <div style="display: inline-flex;"><h3><?php echo $chat_time; ?> </h3><p style="margin-top: 13px;margin-left: 3px;">Minutes</p></div>
                          </div>
                          <div class="icon">
                            <i class="fas fa-comments"></i>
                          </div>
                          <input type="hidden" name="cost_id1" id="cost_id1" value="<?php echo $cost_id; ?>">
                          <a onclick="pass_cost_and_minutes('cost_id1')"  class="small-box-footer">book now <i class="fas fa-check"></i></a>
                        </div>
                      </div>
                      <!-- ./col -->
                  <?php } ?>
                  <?php if ($number == 2) { ?>
                      <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                          <div class="inner">
                            <h3><?php echo $cost; ?>$</h3>
                            <h5>for</h5>
                            <div style="display: inline-flex;"><h3><?php echo $chat_time; ?> </h3><p style="margin-top: 13px;margin-left: 3px;">Minutes</p></div>
                          </div>
                          <div class="icon">
                            <i class="fas fa-comments"></i>
                          </div>
                          <input type="hidden" name="cost_id2" id="cost_id2" value="<?php echo $cost_id; ?>">
                          <a onclick="pass_cost_and_minutes('cost_id2')"  class="small-box-footer">book now <i class="fas fa-check"></i></a>
                        </div>
                      </div>
                      <!-- ./col -->
                  <?php } ?>
                  <?php if ($number == 3) { ?>
                      <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-orange">
                          <div class="inner">
                            <h3><?php echo $cost; ?>$</h3>
                            <h5>for</h5>
                            <div style="display: inline-flex;"><h3><?php echo $chat_time; ?> </h3><p style="margin-top: 13px;margin-left: 3px;">Minutes</p></div>
                          </div>
                          <div class="icon">
                            <i class="fas fa-comments"></i>
                          </div>
                          <input type="hidden" name="cost_id3" id="cost_id3" value="<?php echo $cost_id; ?>">
                          <a onclick="pass_cost_and_minutes('cost_id3')"  class="small-box-footer">book now <i class="fas fa-check"></i></a>
                        </div>
                      </div>
                      <!-- ./col -->
                  <?php } ?>
                  <?php if ($number == 4) { ?>
                      <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                          <div class="inner">
                            <h3><?php echo $cost; ?>$</h3>
                            <h5>for</h5>
                            <div style="display: inline-flex;"><h3><?php echo $chat_time; ?> </h3><p style="margin-top: 13px;margin-left: 3px;">Minutes</p></div>
                          </div>
                          <div class="icon">
                            <i class="fas fa-comments"></i>
                          </div>
                          <input type="hidden" name="cost_id4" id="cost_id4" value="<?php echo $cost_id; ?>">
                          <a onclick="pass_cost_and_minutes('cost_id4')"  class="small-box-footer">book now <i class="fas fa-check"></i></a>
                        </div>
                      </div>
                      <!-- ./col -->
                  <?php } ?>
                  <?php if ($number == 5) { ?>
                      <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-teal">
                          <div class="inner">
                            <h3><?php echo $cost; ?>$</h3>
                            <h5>for</h5>
                            <div style="display: inline-flex;"><h3><?php echo $chat_time; ?> </h3><p style="margin-top: 13px;margin-left: 3px;">Minutes</p></div>
                          </div>
                          <div class="icon">
                            <i class="fas fa-comments"></i>
                          </div>
                          <input type="hidden" name="cost_id5" id="cost_id5" value="<?php echo $cost_id; ?>">
                          <a onclick="pass_cost_and_minutes('cost_id5')"  class="small-box-footer">book now <i class="fas fa-check"></i></a>
                        </div>
                      </div>
                      <div class="col-lg-3 col-6">
                      </div>



                      <!-- ./col -->
                  <?php } ?>

                <?php }
              } ?>

                    </div>
                    <!-- /.row -->
                    <!-- Main row -->

                    <!-- /.row (main row) -->
                  </div><!-- /.container-fluid -->
                </section>
              </div>
            </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->





<a href="" type="hidden" id="popup_a" data-toggle='modal' data-target='#exampleModal' data-whatever='@mdo' ></a>
</div>
<!-- ./wrapper -->
  <!-- Start Private Post Popup -->
<form action="user_private_chat2.php?u_id=<?php echo $user_id; ?>" method="POST" enctype='multipart/form-data'>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalLabel" style="display:inline-block">book a private chat with doctor <?php  echo $f_name; ?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
            <!-- impoetant data -->
            <input type="hidden" name="final_day_id" id="final_day_id" value="0">
            <input type="hidden" name="final_cost_id" id="final_cost_id" value="0">
            <input type="hidden" name="finial_credit" id="finial_credit" value="0">
            <input type="hidden" name="doc_id" id="doc_id" value="<?php echo $userown_id; ?>">
            <input type="hidden" name="final_day" id="final_day">
            <input type="hidden" name="final_month" id="final_month">
            <input type="hidden" name="final_year" id="final_year">
            <input type="hidden" name="target_day" id="target_day">

        <div class="modal-footer">
          <input type="submit" value="Confirm Booking" name="book_data" class="btn btn-info"/>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</form>

  <!-- End Private Post Popup -->
<script>
  window.setInterval(function() {
  $('figcaption').slideToggle();
}, 500);

function checkAll(e) {
   var checkboxes = document.getElementsByName('check');
 
   if (e.checked) {
     for (var i = 0; i < checkboxes.length; i++) { 
       checkboxes[i].checked = false;
     }
     e.checked = true;
   }
 }
function displaychatlimit(e,id) {
     if (e.checked) {
        var element = document.getElementById("time");
        element.classList.remove("chatlimit");

        document.getElementById("nowtext").innerHTML="Now choose chat cost and time";


       // var element = document.getElementById("try").click();
     }
     else
     {
        var element = document.getElementById("time");
        element.classList.add("chatlimit"); 

        document.getElementById("nowtext").innerHTML="Select day from above first";
   
     }
     pass_day(id);
}
function pass_day(id1){
    document.getElementById("final_day_id").value = document.getElementById(id1).value;
}
function pass_cost_and_minutes(id1){
    document.getElementById("final_cost_id").value = document.getElementById(id1).value;
    
    if (document.getElementById("current_credit").value == "") {
      alert("please Enter Credit Card then booking");
    }
    else{
      document.getElementById('popup_a').click();
    }
}
</script>
  <script>
  var d = new Date();
  document.getElementById("final_day").value = d.getDate();
  document.getElementById("final_month").value = d.getMonth()+1;
  document.getElementById("final_year").value = d.getFullYear();

  var d = new Date();
  var weekday = new Array(7);

  weekday[0] = 2;
  weekday[1] = 3;
  weekday[2] = 4;
  weekday[3] = 5;
  weekday[4] = 6;
  weekday[5] = 7;
  weekday[6] = 1;

  var n = weekday[d.getDay()];
  document.getElementById("target_day").innerHTML = n+1;

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<?php }else{
      echo "<script>alert('There Is No ID Exist !')</script>";
        echo "<script>window.open('home.php','_self')</script>";
} ?>

<?php } ?>