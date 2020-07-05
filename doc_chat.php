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
		$type = $row['type'];

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Private Chat</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="mystylesheet.css">
</head>
<body class="hold-transition sidebar-mini" style="background-color: #c2c2c2;">
<div class="wrapper"> 
<form method='POST' enctype='multipart/form-data'> 
 <div class="col-lg-12 row" style="margin-top: 20px;">
    <div class="" style="margin-left: 20px;">
    <a href="home.php" style="color: black;"><i title="Home" class="fa fa-home fa-3x" aria-hidden="true"></i></a>
    </div>
    <div class="col-lg-3" style="margin-left: 15px;margin-right: -70px;">
    <a href="doc_profile.php?u_id=<?php echo $user_id; ?>" style="color: black;"><i title="Your Profile" class="fa fa-user-circle fa-3x" aria-hidden="true"></i></a>
    </div>

    <?php  
        if ($private_chat == 0) {
    ?>
    <center>
      <div class="alert alert-warning alert-dismissible col-lg-12" style="margin-left: 10px;margin-right: 20px;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                  by default, Private chat with patients disactive, you can active it by change below setting! <br>
                  this message will never appear after active your private chat and save changes
      </div>
    </center>
  <?php } ?>
</div><br>

<!-- select avalaible days -->
<div class="card" style="margin-left: 20px;margin-right: 20px;"> 
    <div class="card-header">
      <h5>First be available one day at least in the week to active private chat</h5>
    </div>  
    <div class=" card-body" style="background-color: #e0e0e0;">
      <div class="row">
        <div id="time" class="col-lg-4 ">
          <div class="card card-secondary">
            <div class="card-header">
              <h1 class="card-title">Saturday </h1>
                  <div style="float: right;">
                    <div class="icheck-primary d-inline ml-2">

                      <input type="checkbox" name='check1' id="Check1" checked="" onchange="notavalabile1(this)">
                      <label for="Check1" ><p class="badge badge-danger card-title">Not Avalaible</p></label> 

                    </div>
                    <div class="icheck-primary d-inline ml-2">

                      <input type="checkbox" name='check1' id="Check11" onchange="avalabile1(this)">
                      <label for="Check11" ><p class="badge badge-success card-title">Avalaible</p></label>  

                    </div> 
                  </div>       
            </div>
            <div class="card-body  row chatlimit" id="body1">
              <h2>From</h2>
              <div class="col-lg-4">
                <div class="input-group">
                  <select name="day1_from" required="" class="form-control" style="height: 50px;padding-right: 0px;">
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                    <option value="11"> 11 </option>
                    <option value="12"> 12 </option>
                  </select>
                  <div class="input-group-prepend" style="display: inline-block;">
                    <span class="input-group-text" style="max-height: 25px;">AM <input style="margin-left: 4px;" type="radio" checked="" onchange="myradio1(this)" name="radio1" id="radio1"></span>
                    <span class="input-group-text" style="max-height: 25px;">PM <input style="margin-left: 4px;" type="radio" onchange="myradio1(this)" name="radio1" id="radio2"></span>
                  </div>
                </div>
              </div>
              <h2>To</h2>
              <div class="col-lg-4">
                <div class="input-group">
                  <select name="day1_to" class="form-control" style="height: 50px;padding-right: 0px;">
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                    <option value="11"> 11 </option>
                    <option value="12"> 12 </option>
                  </select>
                  <div class="input-group-prepend" style="display: inline-block;">
                    <span class="input-group-text" style="max-height: 25px;">AM <input style="margin-left: 4px;" type="radio" checked="" onchange="myradio2(this)" name="radio2" id="radio3"></span>
                    <span class="input-group-text" style="max-height: 25px;">PM <input style="margin-left: 4px;" type="radio" onchange="myradio2(this)" name="radio2" id="radio4"></span>
                  </div>
                </div>
              </div>
                    <input value="0" style="display:none;" id="day1" name="day1">
                    <input value="1" style="display:none;" id="from_am_pm1" name="from_am_pm1">
                    <input value="1" style="display:none;" id="to_am_pm1" name="to_am_pm1">
            </div>
          </div>
        </div>
        <div id="time" class="col-lg-4">
          <div class="card card-secondary">
            <div class="card-header">
              <h1 class="card-title">Sunday </h1>
                  <div style="float: right;">
                    <div class="icheck-primary d-inline ml-2">

                      <input type="checkbox" name='check2' id="Check2" checked="" onchange="notavalabile2(this)">
                      <label for="Check2" ><p class="badge badge-danger card-title">Not Avalaible</p></label> 

                    </div>
                    <div class="icheck-primary d-inline ml-2">

                      <input type="checkbox" name='check2' id="Check22" onchange="avalabile2(this)">
                      <label for="Check22" ><p class="badge badge-success card-title">Avalaible</p></label>  

                    </div> 
                  </div>
            </div>
            <div class="card-body row chatlimit" id="body2">
              <h4>From</h4>
              <div class="col-lg-4">
                <div class="input-group">
                  <select name="day2_from" class="form-control" style="height: 50px;padding-right: 0px;">
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                    <option value="11"> 11 </option>
                    <option value="12"> 12 </option>
                  </select>
                  <div class="input-group-prepend" style="display: inline-block;">
                    <span class="input-group-text" style="max-height: 25px;">AM <input style="margin-left: 4px;" type="radio" checked="" onchange="myradio3(this)" name="radio3" id="radio5"></span>
                    <span class="input-group-text" style="max-height: 25px;">PM <input style="margin-left: 4px;" type="radio" onchange="myradio3(this)" name="radio3" id="radio6"></span>
                  </div>
                </div>
              </div>
              <h4>To</h4>
              <div class="col-lg-4">
                <div class="input-group">
                  <select name="day2_to" class="form-control" style="height: 50px;padding-right: 0px;">
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                    <option value="11"> 11 </option>
                    <option value="12"> 12 </option>
                  </select>
                  <div class="input-group-prepend" style="display: inline-block;">
                    <span class="input-group-text" style="max-height: 25px;">AM <input style="margin-left: 4px;" type="radio" checked="" onchange="myradio4(this)" name="radio4" id="radio7"></span>
                    <span class="input-group-text" style="max-height: 25px;">PM <input style="margin-left: 4px;" type="radio" onchange="myradio4(this)" name="radio4" id="radio8"></span>
                  </div>
                </div>
              </div>
                    <input value="0" style="display:none;" id="day2" name="day2">
                    <input value="1" style="display:none;" id="from_am_pm2" name="from_am_pm2">
                    <input value="1" style="display:none;" id="to_am_pm2" name="to_am_pm2">
            </div>
          </div>
        </div>
        <div id="time" class="col-lg-4">
          <div class="card card-secondary">
            <div class="card-header">
              <h1 class="card-title">Monday </h1>
                  <div style="float: right;">
                    <div class="icheck-primary d-inline ml-2">

                      <input type="checkbox" name='check3' id="Check3" checked="" onchange="notavalabile3(this)">
                      <label for="Check3" ><p class="badge badge-danger card-title">Not Avalaible</p></label> 

                    </div>
                    <div class="icheck-primary d-inline ml-2">

                      <input type="checkbox" name='check3' id="Check33" onchange="avalabile3(this)">
                      <label for="Check33" ><p class="badge badge-success card-title">Avalaible</p></label>  

                    </div> 
                  </div>
            </div>
            <div class="card-body row chatlimit" id="body3">
              <h4>From</h4>
              <div class="col-lg-4">
                <div class="input-group">
                  <select name="day3_from" class="form-control" style="height: 50px;padding-right: 0px;">
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                    <option value="11"> 11 </option>
                    <option value="12"> 12 </option>
                  </select>
                  <div class="input-group-prepend" style="display: inline-block;">
                    <span class="input-group-text" style="max-height: 25px;">AM <input style="margin-left: 4px;" type="radio" checked="" onchange="myradio5(this)" name="radio5" id="radio9"></span>
                    <span class="input-group-text" style="max-height: 25px;">PM <input style="margin-left: 4px;" type="radio" onchange="myradio5(this)" name="radio5" id="radio10"></span>
                  </div>
                </div>
              </div>
              <h4>To</h4>
              <div class="col-lg-4">
                <div class="input-group">
                  <select name="day3_to" class="form-control" style="height: 50px;padding-right: 0px;">
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                    <option value="11"> 11 </option>
                    <option value="12"> 12 </option>
                  </select>
                  <div class="input-group-prepend" style="display: inline-block;">
                    <span class="input-group-text" style="max-height: 25px;">AM <input style="margin-left: 4px;" type="radio" checked="" onchange="myradio6(this)" name="radio6" id="radio11"></span>
                    <span class="input-group-text" style="max-height: 25px;">PM <input style="margin-left: 4px;" type="radio" onchange="myradio6(this)" name="radio6" id="radio12"></span>
                  </div>
                </div>
              </div>
                    <input value="0" style="display:none;" id="day3" name="day3">
                    <input value="1" style="display:none;" id="from_am_pm3" name="from_am_pm3">
                    <input value="1" style="display:none;" id="to_am_pm3" name="to_am_pm3">
            </div>
          </div>
        </div>
        <div id="time" class="col-lg-4">
          <div class="card card-secondary">
            <div class="card-header">
              <h1 class="card-title">Tuesday </h1>
                  <div style="float: right;">
                    <div class="icheck-primary d-inline ml-2">

                      <input type="checkbox" name='check4' id="Check4" checked="" onchange="notavalabile4(this)">
                      <label for="Check4" ><p class="badge badge-danger card-title">Not Avalaible</p></label> 

                    </div>
                    <div class="icheck-primary d-inline ml-2">

                      <input type="checkbox" name='check4' id="Check44" onchange="avalabile4(this)">
                      <label for="Check44" ><p class="badge badge-success card-title">Avalaible</p></label>  

                    </div> 
                  </div>
            </div>
            <div class="card-body row chatlimit" id="body4">
              <h4>From</h4>
              <div class="col-lg-4">
                <div class="input-group">
                  <select name="day4_from" class="form-control" style="height: 50px;padding-right: 0px;">
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                    <option value="11"> 11 </option>
                    <option value="12"> 12 </option>
                  </select>
                  <div class="input-group-prepend" style="display: inline-block;">
                    <span class="input-group-text" style="max-height: 25px;">AM <input style="margin-left: 4px;" type="radio" checked="" onchange="myradio7(this)" name="radio7" id="radio13"></span>
                    <span class="input-group-text" style="max-height: 25px;">PM <input style="margin-left: 4px;" type="radio" onchange="myradio7(this)" name="radio7" id="radio14"></span>
                  </div>
                </div>
              </div>
              <h4>To</h4>
              <div class="col-lg-4">
                <div class="input-group">
                  <select name="day4_to" class="form-control" style="height: 50px;padding-right: 0px;">
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                    <option value="11"> 11 </option>
                    <option value="12"> 12 </option>
                  </select>
                  <div class="input-group-prepend" style="display: inline-block;">
                    <span class="input-group-text" style="max-height: 25px;">AM <input style="margin-left: 4px;" type="radio" checked="" onchange="myradio8(this)" name="radio8" id="radio15"></span>
                    <span class="input-group-text" style="max-height: 25px;">PM <input style="margin-left: 4px;" type="radio" onchange="myradio8(this)" name="radio8" id="radio16"></span>
                  </div>
                </div>
              </div>
                    <input value="0" style="display:none;" id="day4" name="day4">
                    <input value="1" style="display:none;" id="from_am_pm4" name="from_am_pm4">
                    <input value="1" style="display:none;" id="to_am_pm4" name="to_am_pm4">
            </div>
          </div>
        </div>
        <div id="time" class="col-lg-4">
          <div class="card card-secondary">
            <div class="card-header">
              <h1 class="card-title">Wednesday </h1>
                  <div style="float: right;">
                    <div class="icheck-primary d-inline ml-2">

                      <input type="checkbox" name='check5' id="Check5" checked="" onchange="notavalabile5(this)">
                      <label for="Check5" ><p class="badge badge-danger card-title">Not Avalaible</p></label> 

                    </div>
                    <div class="icheck-primary d-inline ml-2">

                      <input type="checkbox" name='check5' id="Check55" onchange="avalabile5(this)">
                      <label for="Check55" ><p class="badge badge-success card-title">Avalaible</p></label>  

                    </div> 
                  </div>
            </div>
            <div class="card-body row chatlimit" id="body5">
              <h4>From</h4>
              <div class="col-lg-4">
                <div class="input-group">
                  <select name="day5_from" class="form-control" style="height: 50px;padding-right: 0px;">
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                    <option value="11"> 11 </option>
                    <option value="12"> 12 </option>
                  </select>
                  <div class="input-group-prepend" style="display: inline-block;">
                    <span class="input-group-text" style="max-height: 25px;">AM <input style="margin-left: 4px;" type="radio" checked="" onchange="myradio9(this)" name="radio9" id="radio17"></span>
                    <span class="input-group-text" style="max-height: 25px;">PM <input style="margin-left: 4px;" type="radio" onchange="myradio9(this)" name="radio9" id="radio18"></span>
                  </div>
                </div>
              </div>
              <h4>To</h4>
              <div class="col-lg-4">
                <div class="input-group">
                  <select name="day5_to" class="form-control" style="height: 50px;padding-right: 0px;">
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                    <option value="11"> 11 </option>
                    <option value="12"> 12 </option>
                  </select>
                  <div class="input-group-prepend" style="display: inline-block;">
                    <span class="input-group-text" style="max-height: 25px;">AM <input style="margin-left: 4px;" type="radio" checked="" onchange="myradio10(this)" name="radio10" id="radio19"></span>
                    <span class="input-group-text" style="max-height: 25px;">PM <input style="margin-left: 4px;" type="radio" onchange="myradio10(this)" name="radio10" id="radio20"></span>
                  </div>
                </div>
              </div>
                    <input value="0" style="display:none;" id="day5" name="day5">
                    <input value="1" style="display:none;" id="from_am_pm5" name="from_am_pm5">
                    <input value="1" style="display:none;" id="to_am_pm5" name="to_am_pm5">
            </div>
          </div>
        </div>
        <div id="time" class="col-lg-4">
          <div class="card card-secondary">
            <div class="card-header">
              <h1 class="card-title">Thursday </h1>
                  <div style="float: right;">
                    <div class="icheck-primary d-inline ml-2">

                      <input type="checkbox" name='check6' id="Check6" checked="" onchange="notavalabile6(this)">
                      <label for="Check6" ><p class="badge badge-danger card-title">Not Avalaible</p></label> 

                    </div>
                    <div class="icheck-primary d-inline ml-2">

                      <input type="checkbox" name='check6' id="Check66" onchange="avalabile6(this)">
                      <label for="Check66" ><p class="badge badge-success card-title">Avalaible</p></label>  

                    </div> 
                  </div>
            </div>
            <div class="card-body row chatlimit" id="body6">
              <h4>From</h4>
              <div class="col-lg-4">
                <div class="input-group">
                  <select name="day6_from" class="form-control" style="height: 50px;padding-right: 0px;">
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                    <option value="11"> 11 </option>
                    <option value="12"> 12 </option>
                  </select>
                  <div class="input-group-prepend" style="display: inline-block;">
                    <span class="input-group-text" style="max-height: 25px;">AM <input style="margin-left: 4px;" type="radio" checked="" onchange="myradio11(this)" name="radio11" id="radio21"></span>
                    <span class="input-group-text" style="max-height: 25px;">PM <input style="margin-left: 4px;" type="radio" onchange="myradio11(this)" name="radio11" id="radio22"></span>
                  </div>
                </div>
              </div>
              <h4>To</h4>
              <div class="col-lg-4">
                <div class="input-group">
                  <select name="day6_to" class="form-control" style="height: 50px;padding-right: 0px;">
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                    <option value="11"> 11 </option>
                    <option value="12"> 12 </option>
                  </select>
                  <div class="input-group-prepend" style="display: inline-block;">
                    <span class="input-group-text" style="max-height: 25px;">AM <input style="margin-left: 4px;" type="radio" checked="" onchange="myradio12(this)" name="radio12" id="radio23"></span>
                    <span class="input-group-text" style="max-height: 25px;">PM <input style="margin-left: 4px;" type="radio" onchange="myradio12(this)" name="radio12" id="radio24"></span>
                  </div>
                </div>
              </div>
                    <input value="0" style="display:none;" id="day6" name="day6">
                    <input value="1" style="display:none;" id="from_am_pm6" name="from_am_pm6">
                    <input value="1" style="display:none;" id="to_am_pm6" name="to_am_pm6">
            </div>
          </div>
        </div>
        <div id="time" class="col-lg-4">
          <div class="card card-secondary">
            <div class="card-header">
              <h1 class="card-title">Friday </h1>
                  <div style="float: right;">
                    <div class="icheck-primary d-inline ml-2">

                      <input type="checkbox" name='check7' id="Check7" checked="" onchange="notavalabile7(this)">
                      <label for="Check7" ><p class="badge badge-danger card-title">Not Avalaible</p></label> 

                    </div>
                    <div class="icheck-primary d-inline ml-2">

                      <input type="checkbox" name='check7' id="Check77" onchange="avalabile7(this)">
                      <label for="Check77" ><p class="badge badge-success card-title">Avalaible</p></label>  

                    </div> 
                  </div>
            </div>
            <div class="card-body row chatlimit" id="body7">
              <h4>From</h4>
              <div class="col-lg-4">
                <div class="input-group">
                  <select name="day7_from" class="form-control" style="height: 50px;padding-right: 0px;">
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                    <option value="11"> 11 </option>
                    <option value="12"> 12 </option>
                  </select>
                  <div class="input-group-prepend" style="display: inline-block;">
                    <span class="input-group-text" style="max-height: 25px;">AM <input style="margin-left: 4px;" type="radio" checked="" onchange="myradio13(this)" name="radio13" id="radio25"></span>
                    <span class="input-group-text" style="max-height: 25px;">PM <input style="margin-left: 4px;" type="radio" onchange="myradio13(this)" name="radio13" id="radio26"></span>
                  </div>
                </div>
              </div>
              <h4>To</h4>
              <div class="col-lg-4">
                <div class="input-group">
                  <select name="day7_to" class="form-control" style="height: 50px;padding-right: 0px;">
                    <option value="1"> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                    <option value="6"> 6 </option>
                    <option value="7"> 7 </option>
                    <option value="8"> 8 </option>
                    <option value="9"> 9 </option>
                    <option value="10"> 10 </option>
                    <option value="11"> 11 </option>
                    <option value="12"> 12 </option>
                  </select>
                  <div class="input-group-prepend" style="display: inline-block;">
                    <span class="input-group-text" style="max-height: 25px;">AM <input style="margin-left: 4px;" type="radio" checked="" onchange="myradio14(this)" name="radio14" id="radio27"></span>
                    <span class="input-group-text" style="max-height: 25px;">PM <input style="margin-left: 4px;" type="radio" onchange="myradio14(this)" name="radio14" id="radio28"></span>
                  </div>
                </div>
              </div>
                    <input value="0" style="display:none;" id="day7" name="day7">
                    <input value="1" style="display:none;" id="from_am_pm7" name="from_am_pm7">
                    <input value="1" style="display:none;" id="to_am_pm7" name="to_am_pm7">
            </div>
          </div>
        </div>
      </div>

    </div>
</div><br>

<!-- select cost and chat limit -->
<div class="col-lg-12">
    <div class="card" style="margin-right: 10px;margin-left: 10px;">
          <div class="card-header border-0">
            <div class="d-flex justify-content-between">
            <h5 id="bodytext">Be available one day at least to active this fiture</h5>
</div>
</div>
<div class="card-body chatlimit" id="costbody" style="background-color: ;">
    <div class="col-sm-6">
        <!-- checkbox -->
        <div class="form-group clearfix">
          <div class="icheck-primary d-inline row">
            <input checked="" type="checkbox" id="money1" onchange="moneyandminutes(this,'selectdolar1', 'selectminutes1')">
            <label for="money1"></label>
                <select name="selectdolar1" id="selectdolar1" class="">
                  <option value="1"> 1 $</option>
                  <option value="2"> 2 $</option>
                  <option value="3"> 3 $</option>
                  <option value="4"> 4 $</option>
                  <option value="5"> 5 $</option>
                  <option value="6"> 6 $</option>
                  <option value="7"> 7 $</option>
                  <option value="8"> 8 $</option>
                  <option value="9"> 9 $</option>
                  <option value="10"> 20 $</option>
                </select >
                <span class="h5">  For </span>
                <select name="selectminutes1" id="selectminutes1" class="">
                  <option value="1"> 1 </option>
                  <option value="15"> 15 </option>
                  <option value="30"> 30 </option>
                  <option value="45"> 45 </option>
                  <option value="60"> 60 </option>
                </select>
                <span class="h5">  Minutes </span>
          </div>
                <input value="1" style="display:none;" id="chatclick1" name="chatclick1">
        </div>
        <div class="form-group clearfix">
          <div class="icheck-primary d-inline row">
            <input type="checkbox" id="money2" onchange="moneyandminutes(this,'selectdolar2', 'selectminutes2')">
            <label for="money2"></label>
                <select name="selectdolar2" id="selectdolar2" class="chatlimit">
                  <option value="1"> 1 $</option>
                  <option value="2"> 2 $</option>
                  <option value="3"> 3 $</option>
                  <option value="4"> 4 $</option>
                  <option value="5"> 5 $</option>
                  <option value="6"> 6 $</option>
                  <option value="7"> 7 $</option>
                  <option value="8"> 8 $</option>
                  <option value="9"> 9 $</option>
                  <option value="10"> 10 $</option>
                </select >
                <span class="h5">  For </span>
                <select name="selectminutes2" id="selectminutes2" class="chatlimit">
                  <option value="1"> 1 </option>
                  <option value="15"> 15 </option>
                  <option value="30"> 30 </option>
                  <option value="45"> 45 </option>
                  <option value="60"> 60 </option>
                </select>
                <span class="h5">  Minutes </span>
          </div>
               <input value="0" style="display:none;" id="chatclick2" name="chatclick2">
        </div>
        <div class="form-group clearfix">
          <div class="icheck-primary d-inline row">
            <input type="checkbox" id="money3" onchange="moneyandminutes(this,'selectdolar3', 'selectminutes3')">
            <label for="money3"></label>
                <select name="selectdolar3" id="selectdolar3" class="chatlimit">
                  <option value="1"> 1 $</option>
                  <option value="2"> 2 $</option>
                  <option value="3"> 3 $</option>
                  <option value="4"> 4 $</option>
                  <option value="5"> 5 $</option>
                  <option value="6"> 6 $</option>
                  <option value="7"> 7 $</option>
                  <option value="8"> 8 $</option>
                  <option value="9"> 9 $</option>
                  <option value="10"> 10 $</option>
                </select >
                <span class="h5">  For </span>
                <select name="selectminutes3" id="selectminutes3" class="chatlimit">
                  <option value="1"> 1 </option>
                  <option value="15"> 15 </option>
                  <option value="30"> 30 </option>
                  <option value="45"> 45 </option>
                  <option value="60"> 60 </option>
                </select>
                <span class="h5">  Minutes </span>
          </div>
                <input value="0" style="display:none;" id="chatclick3" name="chatclick3">
        </div>
        <div class="form-group clearfix">
          <div class="icheck-primary d-inline row">
            <input type="checkbox" id="money4" onchange="moneyandminutes(this,'selectdolar4', 'selectminutes4')">
            <label for="money4"></label>
                <select name="selectdolar4" id="selectdolar4" class="chatlimit">
                  <option value="1"> 1 $</option>
                  <option value="2"> 2 $</option>
                  <option value="3"> 3 $</option>
                  <option value="4"> 4 $</option>
                  <option value="5"> 5 $</option>
                  <option value="6"> 6 $</option>
                  <option value="7"> 7 $</option>
                  <option value="8"> 8 $</option>
                  <option value="9"> 9 $</option>
                  <option value="10"> 10 $</option>
                </select >
                <span class="h5">  For </span>
                <select name="selectminutes4" id="selectminutes4" class="chatlimit">
                  <option value="1"> 1 </option>
                  <option value="15"> 15 </option>
                  <option value="30"> 30 </option>
                  <option value="45"> 45 </option>
                  <option value="60"> 60 </option>
                </select>
                <span class="h5">  Minutes </span>
          </div>
                <input value="0" style="display:none;" id="chatclick4" name="chatclick4">
        </div>
        <div class="form-group clearfix">
          <div class="icheck-primary d-inline row">
            <input type="checkbox" id="money5" onchange="moneyandminutes(this,'selectdolar5', 'selectminutes5')">
            <label for="money5"></label>
                <select name="selectdolar5" id="selectdolar5" class="chatlimit">
                  <option value="1"> 1 $</option>
                  <option value="2"> 2 $</option>
                  <option value="3"> 3 $</option>
                  <option value="4"> 4 $</option>
                  <option value="5"> 5 $</option>
                  <option value="6"> 6 $</option>
                  <option value="7"> 7 $</option>
                  <option value="8"> 8 $</option>
                  <option value="9"> 9 $</option>
                  <option value="10"> 10 $</option>
                </select >
                <span class="h5">  For </span>
                <select name="selectminutes5" id="selectminutes5" class="chatlimit">
                  <option value="1"> 1 </option>
                  <option value="15"> 15 </option>
                  <option value="30"> 30 </option>
                  <option value="45"> 45 </option>
                  <option value="60"> 60 </option>
                </select>
                <span class="h5">  Minutes </span>
          </div>
                <input value="0" style="display:none;" id="chatclick5" name="chatclick5">
        </div>

    </div>
</div>
</div>
</div><br>

<!-- Cridet Card Field -->
<div class="card" style="margin-left: 20px;margin-right: 20px;">
  <div class="card-header">
    <h3 class="card-title">Third and finally, please Write your Credit Card in box below</h3><br>
    <h3 class="card-title"><strong>Hint: </strong>We will take <span style="color: red;"><strong>10%</strong></span> from every chat cost</h3>
  </div>
  <div class="card-body" style="background-color: #e0e0e0;">
    <p style="color: red;">Be carefull while write your Card</p>
    <input type="text" name="my_credit_card" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="14" required="" class="form-control col-lg-6" placeholder="write any numbers, this field just for try">
  </div>
</div>

<!-- Submit all data -->
<center class="" style="">
  <p id="submittext">Set data in one field at least in every above dialog to active Save buttom (like days and chat cost and credit card) </p>
  <button type="submit" name="submit" id="submit" class="btn btn-primary chatlimit"  style="width: 40%; margin-bottom: 30px;">Save all Above changes</button>
</center>
</form>
</div>

<?php

if(isset($_POST['submit'])){

  $private_chat = 1;
  $credit_card = htmlentities($_POST['my_credit_card']);

  $day1 = htmlentities($_POST['day1']);
  $day2 = htmlentities($_POST['day2']);
  $day3 = htmlentities($_POST['day3']);
  $day4 = htmlentities($_POST['day4']);
  $day5 = htmlentities($_POST['day5']);
  $day6 = htmlentities($_POST['day6']);
  $day7 = htmlentities($_POST['day7']);

  $chatclick1 = htmlentities($_POST['chatclick1']);
  $chatclick2 = htmlentities($_POST['chatclick2']);
  $chatclick3 = htmlentities($_POST['chatclick3']);
  $chatclick4 = htmlentities($_POST['chatclick4']);
  $chatclick5 = htmlentities($_POST['chatclick5']);

  $delete1 = $con->prepare("DELETE FROM pctt WHERE doc_id = $user_id") ;
  $delete1->execute();

  $delete2 = $con->prepare("DELETE FROM booked_chat WHERE doc_id = $user_id") ;
  $delete2->execute();


  $update = $con->prepare("UPDATE users SET private_chat ='$private_chat', credit_card='$credit_card' WHERE user_id='$user_id'");
  $update->execute();

  if ($day1) {
    $day = 1;
    $day_chr = "Saturday";
    $doc_id = $user_id;
    $availability = 1;
    $last_book   = 0; 
    $day_from   = htmlentities($_POST['day1_from']);
    $from_am_pm = htmlentities($_POST['from_am_pm1']);
    $day_to     = htmlentities($_POST['day1_to']);
    $to_am_pm   = htmlentities($_POST['to_am_pm1']);

    $insert = $con->prepare("INSERT into pctt(doc_id,day,day_char,availability,last_book,available_from,available_to,from_am_pm,to_am_pm)values('$doc_id','$day','$day_chr','$availability','$last_book','$day_from','$day_to','$from_am_pm','$to_am_pm')");
  }
  else{
    $day = 1;
    $day_chr = "Saturday";
    $doc_id = $user_id;
    $availability = 0;
    $last_book   = 0; 
    $day_from   = 0;
    $from_am_pm = 0;
    $day_to     = 0;
    $to_am_pm   = 0;   

    $insert = $con->prepare("INSERT into pctt(doc_id,day,day_char,availability,last_book,available_from,available_to,from_am_pm,to_am_pm)values('$doc_id','$day','$day_chr','$availability','$last_book','$day_from','$day_to','$from_am_pm','$to_am_pm')");
  }
    $insert ->execute();   

  if ($day2) {
    $day = 2;
    $day_chr = "Sunday";
    $doc_id = $user_id;
    $availability = 1;
    $last_book   = 0; 
    $day_from   = htmlentities($_POST['day2_from']);
    $from_am_pm = htmlentities($_POST['from_am_pm2']);
    $day_to     = htmlentities($_POST['day2_to']);
    $to_am_pm   = htmlentities($_POST['to_am_pm2']);

    $insert = $con->prepare("INSERT into pctt(doc_id,day,day_char,availability,last_book,available_from,available_to,from_am_pm,to_am_pm)values('$doc_id','$day','$day_chr','$availability','$last_book','$day_from','$day_to','$from_am_pm','$to_am_pm')");
  }
  else{
    $day = 2;
    $day_chr = "Sunday";
    $doc_id = $user_id;
    $availability = 0;
    $last_book   = 0; 
    $day_from   = 0;
    $from_am_pm = 0;
    $day_to     = 0;
    $to_am_pm   = 0;   

    $insert = $con->prepare("INSERT into pctt(doc_id,day,day_char,availability,last_book,available_from,available_to,from_am_pm,to_am_pm)values('$doc_id','$day','$day_chr','$availability','$last_book','$day_from','$day_to','$from_am_pm','$to_am_pm')");
  }
    $insert ->execute(); 

  if ($day3) {
    $day = 3;
    $day_chr = "Monday";
    $doc_id = $user_id;
    $availability = 1;
    $last_book   = 0; 
    $day_from   = htmlentities($_POST['day3_from']);
    $from_am_pm = htmlentities($_POST['from_am_pm3']);
    $day_to     = htmlentities($_POST['day3_to']);
    $to_am_pm   = htmlentities($_POST['to_am_pm3']);

    $insert = $con->prepare("INSERT into pctt(doc_id,day,day_char,availability,last_book,available_from,available_to,from_am_pm,to_am_pm)values('$doc_id','$day','$day_chr','$availability','$last_book','$day_from','$day_to','$from_am_pm','$to_am_pm')");
  }
  else{
    $day = 3;
    $day_chr = "Monday";
    $doc_id = $user_id;
    $availability = 0;
    $last_book   = 0; 
    $day_from   = 0;
    $from_am_pm = 0;
    $day_to     = 0;
    $to_am_pm   = 0;   

    $insert = $con->prepare("INSERT into pctt(doc_id,day,day_char,availability,last_book,available_from,available_to,from_am_pm,to_am_pm)values('$doc_id','$day','$day_chr','$availability','$last_book','$day_from','$day_to','$from_am_pm','$to_am_pm')");
  }
    $insert ->execute(); 

  if ($day4) {
    $day = 4;
    $day_chr = "Tuesday";
    $doc_id = $user_id;
    $availability = 1;
    $last_book   = 0; 
    $day_from   = htmlentities($_POST['day4_from']);
    $from_am_pm = htmlentities($_POST['from_am_pm4']);
    $day_to     = htmlentities($_POST['day4_to']);
    $to_am_pm   = htmlentities($_POST['to_am_pm4']);

    $insert = $con->prepare("INSERT into pctt(doc_id,day,day_char,availability,last_book,available_from,available_to,from_am_pm,to_am_pm)values('$doc_id','$day','$day_chr','$availability','$last_book','$day_from','$day_to','$from_am_pm','$to_am_pm')");
  }
  else{
    $day = 4;
    $day_chr = "Tuesday";
    $doc_id = $user_id;
    $availability = 0;
    $last_book   = 0; 
    $day_from   = 0;
    $from_am_pm = 0;
    $day_to     = 0;
    $to_am_pm   = 0;   

    $insert = $con->prepare("INSERT into pctt(doc_id,day,day_char,availability,last_book,available_from,available_to,from_am_pm,to_am_pm)values('$doc_id','$day','$day_chr','$availability','$last_book','$day_from','$day_to','$from_am_pm','$to_am_pm')");
  }
    $insert ->execute(); 

  if ($day5) {
    $day = 5;
    $day_chr = "Wednesday";
    $doc_id = $user_id;
    $availability = 1;
    $last_book   = 0; 
    $day_from   = htmlentities($_POST['day5_from']);
    $from_am_pm = htmlentities($_POST['from_am_pm5']);
    $day_to     = htmlentities($_POST['day5_to']);
    $to_am_pm   = htmlentities($_POST['to_am_pm5']);

    $insert = $con->prepare("INSERT into pctt(doc_id,day,day_char,availability,last_book,available_from,available_to,from_am_pm,to_am_pm)values('$doc_id','$day','$day_chr','$availability','$last_book','$day_from','$day_to','$from_am_pm','$to_am_pm')");
  }
  else{
    $day = 5;
    $day_chr = "Wednesday";
    $doc_id = $user_id;
    $availability = 0;
    $last_book   = 0; 
    $day_from   = 0;
    $from_am_pm = 0;
    $day_to     = 0;
    $to_am_pm   = 0;   

    $insert = $con->prepare("INSERT into pctt(doc_id,day,day_char,availability,last_book,available_from,available_to,from_am_pm,to_am_pm)values('$doc_id','$day','$day_chr','$availability','$last_book','$day_from','$day_to','$from_am_pm','$to_am_pm')");
  }
    $insert ->execute(); 

  if ($day6) {
    $day = 6;
    $day_chr = "Thursday";
    $doc_id = $user_id;
    $availability = 1;
    $last_book   = 0; 
    $day_from   = htmlentities($_POST['day6_from']);
    $from_am_pm = htmlentities($_POST['from_am_pm6']);
    $day_to     = htmlentities($_POST['day6_to']);
    $to_am_pm   = htmlentities($_POST['to_am_pm6']);

    $insert = $con->prepare("INSERT into pctt(doc_id,day,day_char,availability,last_book,available_from,available_to,from_am_pm,to_am_pm)values('$doc_id','$day','$day_chr','$availability','$last_book','$day_from','$day_to','$from_am_pm','$to_am_pm')");
  }
  else{
    $day = 6;
    $day_chr = "Thursday";
    $doc_id = $user_id;
    $availability = 0;
    $last_book   = 0; 
    $day_from   = 0;
    $from_am_pm = 0;
    $day_to     = 0;
    $to_am_pm   = 0;   

    $insert = $con->prepare("INSERT into pctt(doc_id,day,day_char,availability,last_book,available_from,available_to,from_am_pm,to_am_pm)values('$doc_id','$day','$day_chr','$availability','$last_book','$day_from','$day_to','$from_am_pm','$to_am_pm')");
  }
    $insert ->execute(); 

  if ($day7) {
    $day = 7;
    $day_chr = "Friday";
    $doc_id = $user_id;
    $availability = 1;
    $last_book   = 0; 
    $day_from   = htmlentities($_POST['day7_from']);
    $from_am_pm = htmlentities($_POST['from_am_pm7']);
    $day_to     = htmlentities($_POST['day7_to']);
    $to_am_pm   = htmlentities($_POST['to_am_pm7']);

    $insert = $con->prepare("INSERT into pctt(doc_id,day,day_char,availability,last_book,available_from,available_to,from_am_pm,to_am_pm)values('$doc_id','$day','$day_chr','$availability','$last_book','$day_from','$day_to','$from_am_pm','$to_am_pm')");
  }
  else{
    $day = 7;
    $day_chr = "Friday";
    $doc_id = $user_id;
    $availability = 0;
    $last_book   = 0; 
    $day_from   = 0;
    $from_am_pm = 0;
    $day_to     = 0;
    $to_am_pm   = 0;   

    $insert = $con->prepare("INSERT into pctt(doc_id,day,day_char,availability,last_book,available_from,available_to,from_am_pm,to_am_pm)values('$doc_id','$day','$day_chr','$availability','$last_book','$day_from','$day_to','$from_am_pm','$to_am_pm')");
  }


  // insert chat cost
  if ($chatclick1) {
      $doc_id = $user_id;
      $chat_number = 1;
      $cost = htmlentities($_POST['selectdolar1']);
      $time = htmlentities($_POST['selectminutes1']);

      $insert2 = $con->prepare("INSERT into booked_chat(doc_id,cost,chat_time,chat_number)values('$doc_id','$cost','$time','$chat_number')");
      $insert2 ->execute();
  }
  if ($chatclick2) {
      $doc_id = $user_id;
      $chat_number = 2;
      $cost = htmlentities($_POST['selectdolar2']);
      $time = htmlentities($_POST['selectminutes2']);

      $insert2 = $con->prepare("INSERT into booked_chat(doc_id,cost,chat_time,chat_number)values('$doc_id','$cost','$time','$chat_number')");
      $insert2 ->execute();
  }
    if ($chatclick3) {
      $doc_id = $user_id;
      $chat_number = 3;
      $cost = htmlentities($_POST['selectdolar3']);
      $time = htmlentities($_POST['selectminutes3']);

      $insert2 = $con->prepare("INSERT into booked_chat(doc_id,cost,chat_time,chat_number)values('$doc_id','$cost','$time','$chat_number')");
      $insert2 ->execute();
  }
    if ($chatclick4) {
      $doc_id = $user_id;
      $chat_number = 4;
      $cost = htmlentities($_POST['selectdolar4']);
      $time = htmlentities($_POST['selectminutes4']);

      $insert2 = $con->prepare("INSERT into booked_chat(doc_id,cost,chat_time,chat_number)values('$doc_id','$cost','$time','$chat_number')");
      $insert2 ->execute();
  }
    if ($chatclick5) {
      $doc_id = $user_id;
      $chat_number = 5;
      $cost = htmlentities($_POST['selectdolar5']);
      $time = htmlentities($_POST['selectminutes5']);

      $insert2 = $con->prepare("INSERT into booked_chat(doc_id,cost,chat_time,chat_number)values('$doc_id','$cost','$time','$chat_number')");
      $insert2 ->execute();
  }

  if ($delete1 && $delete2 && $update) {
    $insert ->execute(); 
    echo "<script>window.open('doc_chat_settings.php?u_id=$user_id','_self')</script>";
  }
             
    // if($insert){
    //     echo "<script>alert('done')</script>";
    //   //echo "<script>window.open('playlists.php?u_id=$user_id','_self')</script>";
    // }
} 


?>
<script>

function notavalabile1(e) {
     var checkboxes = document.getElementsByName('check1');
     var check11 = document.getElementById("Check11");


     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
       e.checked = true;
       var element = document.getElementById("body1");
       element.classList.add("chatlimit"); 
       document.getElementById("day1").value = 0;
     }
     if (!e.checked && !check11.checked) {
      check11.checked = true;
       var element = document.getElementById("body1");
       element.classList.remove("chatlimit"); 
     document.getElementById("day1").value = 1;
     }
     activemoneyandminutes();
   }
  function avalabile1(e) {
     var checkboxes = document.getElementsByName('check1');
     var check1 = document.getElementById("Check1");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
        var element = document.getElementById("body1");
        element.classList.remove("chatlimit");
        document.getElementById("day1").value = 1;
     }
     if (!e.checked && !check1.checked) {
      check1.checked = true;
       var element = document.getElementById("body1");
       element.classList.add("chatlimit"); 
       document.getElementById("day1").value = 0;
     }
     activemoneyandminutes();
   }
   function notavalabile2(e) {
     var checkboxes = document.getElementsByName('check2');
     var check22 = document.getElementById("Check22");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
       e.checked = true;
       var element = document.getElementById("body2");
       element.classList.add("chatlimit"); 
       document.getElementById("day2").value = 0;
     }
     if (!e.checked && !check22.checked) {
      check22.checked = true;
       var element = document.getElementById("body2");
       element.classList.remove("chatlimit"); 
     document.getElementById("day2").value = 1;
     }
     activemoneyandminutes();
   }
  function avalabile2(e) {
     var checkboxes = document.getElementsByName('check2');
     var check2 = document.getElementById("Check2");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
        var element = document.getElementById("body2");
        element.classList.remove("chatlimit");
       document.getElementById("day2").value = 1;
     }
     if (!e.checked && !check2.checked) {
      check2.checked = true;
       var element = document.getElementById("body2");
       element.classList.add("chatlimit"); 
       document.getElementById("day2").valuevalue = 0;
     }
     activemoneyandminutes();
   }
   function notavalabile3(e) {
     var checkboxes = document.getElementsByName('check3');
     var check33 = document.getElementById("Check33");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
       e.checked = true;
       var element = document.getElementById("body3");
       element.classList.add("chatlimit"); 
       document.getElementById("day3").value = 0;
     }
     if (!e.checked && !check33.checked) {
      check33.checked = true;
       var element = document.getElementById("body3");
       element.classList.remove("chatlimit"); 
     document.getElementById("day3").value = 1;
     }
     activemoneyandminutes();
   }
  function avalabile3(e) {
     var checkboxes = document.getElementsByName('check3');
     var check3 = document.getElementById("Check3");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
        var element = document.getElementById("body3");
        element.classList.remove("chatlimit");
       document.getElementById("day3").value = 1;
     }
     if (!e.checked && !check3.checked) {
      check3.checked = true;
       var element = document.getElementById("body3");
       element.classList.add("chatlimit"); 
       document.getElementById("day3").value = 0;
     }
     activemoneyandminutes();
   }
   function notavalabile4(e) {
     var checkboxes = document.getElementsByName('check4');
     var check44 = document.getElementById("Check44");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
       e.checked = true;
       var element = document.getElementById("body4");
       element.classList.add("chatlimit"); 
       document.getElementById("day4").value = 0;
     }
     if (!e.checked && !check44.checked) {
      check44.checked = true;
       var element = document.getElementById("body4");
       element.classList.remove("chatlimit"); 
     document.getElementById("day4").value = 1;
     }
     activemoneyandminutes();
   }
  function avalabile4(e) {
     var checkboxes = document.getElementsByName('check4');
     var check4 = document.getElementById("Check4");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
        var element = document.getElementById("body4");
        element.classList.remove("chatlimit");
       document.getElementById("day4").value = 1;
     }
     if (!e.checked && !check4.checked) {
      check4.checked = true;
       var element = document.getElementById("body4");
       element.classList.add("chatlimit"); 
       document.getElementById("day4").value = 0;
     }
     activemoneyandminutes();
   }
   function notavalabile5(e) {
     var checkboxes = document.getElementsByName('check5');
     var check55 = document.getElementById("Check55");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
       e.checked = true;
       var element = document.getElementById("body5");
       element.classList.add("chatlimit"); 
       document.getElementById("day5").value = 0;
     }
     if (!e.checked && !check55.checked) {
      check55.checked = true;
       var element = document.getElementById("body5");
       element.classList.remove("chatlimit"); 
     document.getElementById("day5").value = 1;
     }
     activemoneyandminutes();
   }
  function avalabile5(e) {
     var checkboxes = document.getElementsByName('check5');
     var check5 = document.getElementById("Check5");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
        var element = document.getElementById("body5");
        element.classList.remove("chatlimit");
       document.getElementById("day5").value = 1;
     }
     if (!e.checked && !check5.checked) {
      check5.checked = true;
       var element = document.getElementById("body5");
       element.classList.add("chatlimit"); 
       document.getElementById("day5").value = 0;
     }
     activemoneyandminutes();
   }
   function notavalabile6(e) {
     var checkboxes = document.getElementsByName('check6');
     var check66 = document.getElementById("Check66");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
       e.checked = true;
       var element = document.getElementById("body6");
       element.classList.add("chatlimit"); 
       document.getElementById("day6").value = 0;
     }
     if (!e.checked && !check66.checked) {
      check66.checked = true;
       var element = document.getElementById("body6");
       element.classList.remove("chatlimit"); 
     document.getElementById("day6").value = 1;
     }
     activemoneyandminutes();
   }
  function avalabile6(e) {
     var checkboxes = document.getElementsByName('check6');
     var check6 = document.getElementById("Check6");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
        var element = document.getElementById("body6");
        element.classList.remove("chatlimit");
       document.getElementById("day6").value = 1;
     }
     if (!e.checked && !check6.checked) {
      check6.checked = true;
       var element = document.getElementById("body6");
       element.classList.add("chatlimit"); 
       document.getElementById("day6").value = 0;
     }
     activemoneyandminutes();
   }
   function notavalabile7(e) {
     var checkboxes = document.getElementsByName('check7');
     var check77 = document.getElementById("Check77");
     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
       e.checked = true;
       var element = document.getElementById("body7");
       element.classList.add("chatlimit"); 
       document.getElementById("day7").value = 0;
     }
     if (!e.checked && !check77.checked) {
      check77.checked = true;
       var element = document.getElementById("body7");
       element.classList.remove("chatlimit"); 
     document.getElementById("day7").value = 1;
     }
     activemoneyandminutes();
   }
  function avalabile7(e) {
     var checkboxes = document.getElementsByName('check7');
     var check7 = document.getElementById("Check7");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
        var element = document.getElementById("body7");
        element.classList.remove("chatlimit");
       document.getElementById("day7").value = 1;
     }
     if (!e.checked && !check7.checked) {
      check7.checked = true;
       var element = document.getElementById("body7");
       element.classList.add("chatlimit"); 
       document.getElementById("day7").value = 0;
     }
     activemoneyandminutes();
   }


  function myradio1(e) {
     var checkboxes = document.getElementsByName('radio1');
     var radio1 = document.getElementById("radio1");
     var radio2 = document.getElementById("radio2");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
     }
     if (radio1.checked) {
        document.getElementById("from_am_pm1").value = 1;
     }
     if (radio2.checked) {
        document.getElementById("from_am_pm1").value = 2;
     }
   }
  function myradio2(e) {
     var checkboxes = document.getElementsByName('radio2');
     var radio3 = document.getElementById("radio3");
     var radio4 = document.getElementById("radio4");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
     }
     if (radio3.checked) {
        document.getElementById("to_am_pm1").value = 1;
     }
     if (radio4.checked) {
        document.getElementById("to_am_pm1").value = 2;
     }
   }
  function myradio3(e) {
     var checkboxes = document.getElementsByName('radio3');
     var radio5 = document.getElementById("radio5");
     var radio6 = document.getElementById("radio6");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
     }
     if (radio5.checked) {
        document.getElementById("from_am_pm2").value = 1;
     }
     if (radio6.checked) {
        document.getElementById("from_am_pm2").value = 2;
     }
   }
  function myradio4(e) {
     var checkboxes = document.getElementsByName('radio4');
     var radio7 = document.getElementById("radio7");
     var radio8 = document.getElementById("radio8");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
     }
     if (radio7.checked) {
        document.getElementById("to_am_pm2").value = 1;
     }
     if (radio8.checked) {
        document.getElementById("to_am_pm2").value = 2;
     }
   }
  function myradio5(e) {
     var checkboxes = document.getElementsByName('radio5');
     var radio9 = document.getElementById("radio9");
     var radio10 = document.getElementById("radio10");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
     }
     if (radio9.checked) {
        document.getElementById("from_am_pm3").value = 1;
     }
     if (radio10.checked) {
        document.getElementById("from_am_pm3").value = 2;
     }
   }
  function myradio6(e) {
     var checkboxes = document.getElementsByName('radio6');
     var radio11 = document.getElementById("radio11");
     var radio12 = document.getElementById("radio12");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
     }
     if (radio11.checked) {
        document.getElementById("to_am_pm3").value = 1;
     }
     if (radio12.checked) {
        document.getElementById("to_am_pm3").value = 2;
     }
   }
  function myradio7(e) {
     var checkboxes = document.getElementsByName('radio7');
     var radio13 = document.getElementById("radio13");
     var radio14 = document.getElementById("radio14");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
     }
     if (radio13.checked) {
        document.getElementById("from_am_pm4").value = 1;
     }
     if (radio14.checked) {
        document.getElementById("from_am_pm4").value = 2;
     }
   }
  function myradio8(e) {
     var checkboxes = document.getElementsByName('radio8');
     var radio15 = document.getElementById("radio15");
     var radio16 = document.getElementById("radio16");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
     }
     if (radio15.checked) {
        document.getElementById("to_am_pm4").value = 1;
     }
     if (radio16.checked) {
        document.getElementById("to_am_pm4").value = 2;
     }
   }
  function myradio9(e) {
     var checkboxes = document.getElementsByName('radio9');
     var radio17 = document.getElementById("radio17");
     var radio18 = document.getElementById("radio18");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
     }
     if (radio17.checked) {
        document.getElementById("from_am_pm5").value = 1;
     }
     if (radio18.checked) {
        document.getElementById("from_am_pm5").value = 2;
     }
   }
  function myradio10(e) {
     var checkboxes = document.getElementsByName('radio10');
     var radio19 = document.getElementById("radio19");
     var radio20 = document.getElementById("radio20");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
     }
     if (radio19.checked) {
        document.getElementById("to_am_pm5").value = 1;
     }
     if (radio20.checked) {
        document.getElementById("to_am_pm5").value = 2;
     }
   }
  function myradio11(e) {
     var checkboxes = document.getElementsByName('radio11');
     var radio21 = document.getElementById("radio21");
     var radio22 = document.getElementById("radio22");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
     }
     if (radio21.checked) {
        document.getElementById("from_am_pm6").value = 1;
     }
     if (radio22.checked) {
        document.getElementById("from_am_pm6").value = 2;
     }
   }
  function myradio12(e) {
     var checkboxes = document.getElementsByName('radio12');
     var radio23 = document.getElementById("radio23");
     var radio24 = document.getElementById("radio24");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
     }
     if (radio23.checked) {
        document.getElementById("to_am_pm6").value = 1;
     }
     if (radio24.checked) {
        document.getElementById("to_am_pm6").value = 2;
     }
   }
  function myradio13(e) {
     var checkboxes = document.getElementsByName('radio13');
     var radio25 = document.getElementById("radio25");
     var radio26 = document.getElementById("radio26");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
     }
     if (radio25.checked) {
        document.getElementById("from_am_pm7").value = 1;
     }
     if (radio26.checked) {
        document.getElementById("from_am_pm7").value = 2;
     }
   }
  function myradio14(e) {
     var checkboxes = document.getElementsByName('radio14');
     var radio27 = document.getElementById("radio27");
     var radio28 = document.getElementById("radio28");

     if (e.checked) {
       for (var i = 0; i < checkboxes.length; i++) { 
         checkboxes[i].checked = false;
       }
        e.checked = true;
     }
     if (radio27.checked) {
        document.getElementById("to_am_pm7").value = 1;
     }
     if (radio28.checked) {
        document.getElementById("to_am_pm7").value = 2;
     }
   }

function moneyandminutes(id1,id2,id3) {
     if (id1.checked) {
        var money = document.getElementById(id2);
        money.classList.remove("chatlimit");

        var minutes = document.getElementById(id3);
        minutes.classList.remove("chatlimit");
     }
     else
     {
        var money = document.getElementById(id2);
        money.classList.add("chatlimit");

        var minutes = document.getElementById(id3);
        minutes.classList.add("chatlimit"); 
     }
     activSubmit();
     getcleckerchat();
}
</script> 

<script>
function checkAll(e) {
   var checkboxes = document.getElementsByName('check');
 
   if (e.checked) {
     for (var i = 0; i < checkboxes.length; i++) { 
       checkboxes[i].checked = false;
     }
     e.checked = true;
   }
 }
function displaychatlimit(e) {
     if (e.checked) {
        var element = document.getElementById("time");
        element.classList.remove("chatlimit");

        var element = document.getElementById("nowtext");
        element.classList.remove("nowtext");

       // var element = document.getElementById("try").click();
     }
     else
     {
        var element = document.getElementById("time");
        element.classList.add("chatlimit"); 

        var element = document.getElementById("nowtext");
        element.classList.add("nowtext");     
     }
}
function activemoneyandminutes(){
    var element1 = document.getElementById("Check11");
    var element2 = document.getElementById("Check22");
    var element3 = document.getElementById("Check33");
    var element4 = document.getElementById("Check44");
    var element5 = document.getElementById("Check55");
    var element6 = document.getElementById("Check66");
    var element7 = document.getElementById("Check77");
    var mainelement = document.getElementById("costbody");
    var bodytext = document.getElementById("bodytext");
    var submit = document.getElementById("submit");
    var submittext = document.getElementById("submittext");

    if ( element1.checked || element2.checked || element3.checked || element4.checked || element5.checked || element6.checked || element7.checked ) {
        mainelement.classList.remove("chatlimit"); 
        bodytext.innerHTML = "Secend Select cost and chat limit";
        submit.classList.remove("chatlimit"); 
        submittext.innerHTML = "";

    }
    else{
        mainelement.classList.add("chatlimit"); 
        bodytext.innerHTML = "Be avalaible one day at least to active this fiture";
        submit.classList.add("chatlimit"); 
        submittext.innerHTML = "Set data in one field at least in every above dialog to active Save buttom";
    }
}
function activSubmit(){
    var element1 = document.getElementById("money1");
    var element2 = document.getElementById("money2");
    var element3 = document.getElementById("money3");
    var element4 = document.getElementById("money4");
    var element5 = document.getElementById("money5");
    var submit = document.getElementById("submit");
    var submittext = document.getElementById("submittext");

    if ( element1.checked || element2.checked || element3.checked || element4.checked || element5.checked ) {
        submit.classList.remove("chatlimit"); 
        submittext.innerHTML = "";
    }
    else{
        submit.classList.add("chatlimit"); 
        submittext.innerHTML = "Set data in one field at least in every above dialog to active Save buttom";
    }
}
function getcleckerchat(){
    var element1 = document.getElementById("money1");
    var element2 = document.getElementById("money2");
    var element3 = document.getElementById("money3");
    var element4 = document.getElementById("money4");
    var element5 = document.getElementById("money5");
    var chatclick1 = document.getElementById("chatclick1");
    var chatclick2 = document.getElementById("chatclick2");
    var chatclick3 = document.getElementById("chatclick3");
    var chatclick4 = document.getElementById("chatclick4");
    var chatclick5 = document.getElementById("chatclick5");
//|| element2.checked
    if ( element1.checked ) {
        chatclick1.value = 1;
    }
    else{
        chatclick1.value = 0;
    }

    if ( element2.checked ) {
        chatclick2.value = 1;
    }
    else{
        chatclick2.value = 0;
    }
    
    if ( element3.checked ) {
        chatclick3.value = 1;
    }
    else{
        chatclick3.value = 0;
    }

    if ( element4.checked ) {
        chatclick4.value = 1;
    }
    else{
        chatclick4.value = 0;
    }

    if ( element5.checked ) {
        chatclick5.value = 1;
    }
    else{
        chatclick5.value = 0;
    }

}
</script>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>

<?php }else{
      echo "<script>alert('There Is No ID Exist !')</script>";
        echo "<script>window.open('home.php','_self')</script>";
} ?>

<?php } ?>