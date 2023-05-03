<?php

if(isset($_SESSION) && empty($_SESSION['user'])) {
	unset($_SESSION['user']);
	header("Location: /index.php"); 
	exit;
}
?>