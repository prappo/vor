<?php

if(!file_exists('lib/config.php')){
	header('Location: lib/install.php');
}

function vor_settings($val)
{
mysql_connect(HOST, USER, PASS) or die ("can't connect <br>");
mysql_select_db(DB) or die ("Can't counnect to database<br>");
$sql = "SELECT * FROM vor_settings";
$query = mysql_query($sql);
$row = mysql_fetch_array($query);
return $row[$val];
}


?>