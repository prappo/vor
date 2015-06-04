<?php

$page->a('/c_a', function(){
echo "working";
$sql = "SELECT * FROM customers";
$query = mysql_query($sql);
$result = mysql_fetch_array($query);

for($i=0;$i<=10;$i++)
{
	echo $i."<br>";
}

echo "still working";

});

  ?>