<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include 'db_connection.php';
include 'includes/auth.php';
date_default_timezone_set('Asia/Kolkata');

if(isset($_POST['id'])){
    $Id= $_POST['id'];

    $lastactivity =  $db->query('UPDATE Users SET last_activity =? WHERE Id=?', date("Y-m-d H:i:s"), $Id);
    if($lastactivity){
    echo json_encode(["status" => "1","message" =>"Successfully Updated activity."]);
    exit;
    }else{
    echo json_encode(["status" => "0","message" =>"Something is Wrong. Try after some time ."]);
    exit;
    }
}
?>