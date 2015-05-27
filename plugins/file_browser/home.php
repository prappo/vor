<?php  

add_option('menu', function(){
/*	
add_menu('customers', 'Customers', 'users');
add_menu('orders', 'Orders','shopping-cart');
add_menu('employees', 'Employees','male');
add_menu('offices', 'Offices','flag');
add_menu('payments','Payments','dollar');
add_menu('products', 'Products','truck');
add_menu('reports','Reports','bar-chart-o');
*/
menu_start('', 'File Browser', 'folder');
add_menu('browser_file','Browse File', 'file');

menu_end();


});


$page->a('/browser_file', function(){

?>

<iframe style="border: 0; position:absolute; width:80%; height:100%" src="http://localhost/vor_test/plugins/file_browser_vor/main/main.php">


</iframe>



<?php

});


?>