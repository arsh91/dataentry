<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include '../db_connection.php';
include '../includes/auth.php';

if(isset($_POST['id']) && isset($_POST['roleStatus'])){
    $Id= $_POST['id'];
    $roleStatus = $_POST['roleStatus'];

    $changeRole =  $db->query('UPDATE Users SET Role =? WHERE Id=?', $roleStatus, $Id);
    if($changeRole){
    echo json_encode(["status" => "1","message" =>"Successfully Updated.", "Role"=>$roleStatus]);
    exit;
    }else{
    echo json_encode(["status" => "0","message" =>"Something is Wrong. Try after some time ."]);
    exit;
    }
}
?>