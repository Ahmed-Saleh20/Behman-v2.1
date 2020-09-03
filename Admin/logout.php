<?php

	/*
	*
	* Destroy The Session 'Log Out'
	*
	*/
	session_start();   // Start The Session
	session_unset();    // Unset The Data
	session_destroy();  // Destory The Data

	header('Location:index.php');
	exit();

?>