<?php
function site_name(){
	global $settings;
	echo $settings['site_name'];
}

function base_url(){
	global $settings;
	return $settings['base_url'];
}

function load_script($script){
	echo "<script src='app/assets/js/".$script.".js'></script>";
}

function my_log_error($errorMessage){
	date_default_timezone_set('UTC');
	$fp = fopen("app/logs/".date("Y-m-d").".error.log", 'a+');
	fwrite($fp, date("c").'|'.$errorMessage.'|'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].PHP_EOL);
	fclose($fp);
}
