<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
	include '../db_connection.php';
    include '../includes/auth.php';
    date_default_timezone_set('Asia/Kolkata');
    
    if(isset($_POST)){
        $address = $_POST['address'].', '.$_POST['block'].', '.$_POST['tehsil'].', '.$_POST['district'].', '.$_POST['state'].', '.$_POST['pincode'];
            //query for fetch data  from SelfDeclarations table According to adharCard value
            $declarationData =  $db->query('INSERT into SelfDeclarations (Name, GuardianName, GuardianRelation, Address, Block, AdharcardNo, Status, DraftUserId, CreatedAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', $_POST['full_name'], $_POST['guardian_name'], $_POST['guardian_relation'], $address, $_POST['block'], $_POST['adharcard_no'], 'draft', $_SESSION['user']['Id'], date('Y-m-d H:i:s'));
            $declarationDataID = $db->lastInsertID();
        echo json_encode(array("status" => 200, "declarationDataID" => $declarationDataID));
        exit;
      }
 
// ?>