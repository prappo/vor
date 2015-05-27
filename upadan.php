<?php
include('lib/function.php');

$hook_dir = "plugins/";


$hook_files = glob($hook_dir."*_vor/*.php");


$hooks['menu'] = array();


function add_option($on, $func) {
    global $hooks;
    array_push($hooks[$on], $func);
}


foreach($hook_files as $hook_file) {
    require_once($hook_file);
}


foreach($hooks['menu'] as $hook) {
  $content = call_user_func($hook, $content);
}

echo $content ;