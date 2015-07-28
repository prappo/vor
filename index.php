
<?php
session_start();

include('lib/auto_load.php');
include('lib/function.php');


//error_reporting(0);

function customError($errno, $errstr) {
	if (strpos($errstr,'index') !== false) {
    echo "<script>window.top.location='404'</script>";
    }
 
}


//set_error_handler("customError");

class R{
function a($r,callable $c)
{
	$this->r[$r]=$c;
}
function e()
{
	$s=$_SERVER;
	$i='PATH_INFO';
	$p=isset($s[$i])?$s[$i]:'/';
	$this->r[$p]();
}
}

require('lib/core.php');
