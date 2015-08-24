<?php 
session_start();
if($_SESSION['username']==''){
	die("forbidden");
}
error_reporting(0);
require('function.php');
require('config.php');
$action = $_GET['action'];
if($action == 'export'){
	EXPORT_DB(HOST, USER, PASS, DB);
	echo "done";
}
else if($action == 'import'){
	IMPORT_DB(HOST, USER, PASS, DB);
}
else{
	print "invalid input";
}

 ?>