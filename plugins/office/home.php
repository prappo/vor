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
menu_start('', 'Customers', 'users');
add_menu('add_customer','Add New Customer', 'plus');
add_menu('list_customers', 'Customers List', 'list');
menu_end();
add_menu('orders', 'Orders','shopping-cart');
add_menu('employees', 'Employees','male');
add_menu('offices', 'Offices','flag');
add_menu('payments','Payments','dollar');
add_menu('products', 'Products','truck');
add_menu('reports','Reports','bar-chart-o');


});

//add new customer

$page->a('/list_customers', function(){
 
include('files/list_customers.php');

});

$page->a('/add_customer', function(){

if(include('files/add_customer.php'))
{

}
else
{
  echo "file not exist";
}

});

?>