<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
	include '../db_connection.php';
    include '../includes/auth.php';
    
    if(isset($_POST)){
        $adharCard = $_POST['adharCard'];
        $data=[];
            //query for fetch data  from SelfDeclarations table According to adharCard value
            $data = $db->query("SELECT * FROM SelfDeclarations  WHERE AdharcardNo = ?",$adharCard )->fetchArray();  
            $status='notExist'; 
            if(!empty($data)){
                $status='Existed'; 
            }
        echo json_encode(array("status" => $status, "data"=> $data));
        exit;
      }
 
// ?>