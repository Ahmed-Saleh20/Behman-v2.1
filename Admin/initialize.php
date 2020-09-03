<?php

    /* intialize pakages and libraries */ 
    
    	include 'connectDB.php';

    // Routes
    
	    $tpl  = 'includes/templates/';  // Templates Directory
	   	$func = 'includes/functions/';  // Function Directory
	    $css  = 'layout/css/';          // Css Directory
	    $js   = 'layout/js/';           // js Directory
	    


    // Include The Important File
	   	include $func .  'functions.php';
	    include $tpl  .  'header.php';


	//Include Navbar On All Pages Expect the One With $noNavbar Variable

		if (isset($noNavbar) ) { include $tpl  .  'navbar.php'; }


?>