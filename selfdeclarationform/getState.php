<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
	include '../db_connection.php';
    include '../includes/auth.php';
    
    if(isset($_POST)){
        $district = $_POST['district'];
        $data=[];
            $data = $db->query("SELECT State FROM Locations  WHERE District = ?",$district )->fetchArray();  
        echo json_encode(array("status" => 200, "data"=> $data));
        exit;
      }
 
// ?>