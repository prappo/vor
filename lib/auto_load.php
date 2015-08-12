<?php

if(!file_exists('lib/config.php')){
	header('Location: lib/install.php');
}

function vor_settings($val) {
	return end((db_get('vor_settings')))[$val];
}


?>