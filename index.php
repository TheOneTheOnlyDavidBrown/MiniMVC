<?php

	//imports settings and the base controller
	require_once('app/settings/settings.php');
	require_once('core/controllers/core_controller.php');
	require_once('core/libraries/core_library.php');
	
	//loads extensions that are set in autoload in the settings
	foreach($settings['autoload_extensions'] as $extension):
		include('app/extensions/'.$extension.'.php');
		new $extension;
	endforeach;
	
	//loads libraries from the core that are set in autoload in the settings
	foreach($settings['autoload_libraries'] as $library):
		include('core/libraries/'.$library.'.php');
		
		$reflection = new ReflectionMethod($library, '__construct');
		//if library is not a singleton
		if ($reflection->isPublic()) {
			$$library = new $library;
		}
	endforeach;
	
	//iterates through helpers and opens them
	if ($handle = opendir('core/helpers')) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				include('core/helpers/'.$entry);
			}
		}
		closedir($handle);
	}
	
	//sets the controller ($c)
	if(isset($_GET['c'])){
		$c = $_GET['c'];
	}
	else{
		$c = $settings['default_controller'];
	}
	if (!file_exists('app/controllers/'.$c.'.php')){
		$c = $settings['default_controller'];
	}
	
	//loads and instantiates the contoller from the url
	require_once('app/controllers/'.$c.'.php');
	$controller = new $c;
	
	//sets the model from m in the url
	if(isset($_GET['m'])){
		$m = $_GET['m'];
		if(method_exists($controller,$m)){
			$controller->$m();
		}
		else{
			//handle method not being set in the url by defaulting to the index method
			$controller->index();
		}
	}
	else{
		//handle m not being set in the url by defaulting to the index method
		$controller->index();
	}

