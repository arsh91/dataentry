<?php
session_start();
include_once 'includes/db.php';

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'data_entry';

$db = new db($dbhost, $dbuser, $dbpass, $dbname);

?>