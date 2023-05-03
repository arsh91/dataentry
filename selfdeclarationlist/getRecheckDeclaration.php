<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include '../db_connection.php';
include '../includes/auth.php';

if(isset($_POST['id'])){
    $Id= $_POST['id'];

    $declaration =  $db->query('SELECT * FROM SelfDeclarations WHERE Id=?', $Id,)->fetchArray();
    if($declaration){
    echo json_encode(["status" => "1","message" =>"Successfully Updated.", "declaration"=>$declaration]);
    exit;
    }else{
    echo json_encode(["status" => "0","message" =>"Something is Wrong. Try after some time .", "declaration" =>[]]);
    exit;
    }
}
?>