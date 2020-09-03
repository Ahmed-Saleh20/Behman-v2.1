<?php

   /*
    *   
    * This File Include Connection With Database
    *
    */

    ob_start(); 
    $dsn  = 'mysql:host=localhost;dbname=behmandb_v2.1';     
    $user = 'root';                                     
    $pass = '';                                         

    $option = array(                                    
        
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',  
    
    );

    try{

        $con =  new PDO($dsn,$user,$pass,$option);
        $con -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        // echo "<script> alert('Connected To Database Successfully')</script>";

    }catch(PDOException $e){
        echo 'Faild To Connect' . $e->getMessage();
        // echo "<script> alert('Faild To Connect with Database')</script>";
    }
    
?>
