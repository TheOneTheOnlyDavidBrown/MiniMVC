<!DOCTYPE HTML>
<html>
<head>
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="Public">
	<META HTTP-EQUIV="EXPIRES" 
CONTENT="Wed, 01 May 2013 01:00:00 GMT">
	<META HTTP-EQUIV="CONTENT-TYPE" 
CONTENT="text/html; charset=UTF-8">
	<?php if (isset($page_title)):?>
		<title><?php echo site_name().' | '.$page_title;?></title>
	<?php else:?>
		<title><?php echo site_name();?></title>
	<?php endif;?>
	<link rel="stylesheet" href="app/assets/css/main.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script> 
	<?php load_script('inherit.min')?>
	<?php load_script('main')?>
	<?php load_script('calculator')?>

</head>
<body>