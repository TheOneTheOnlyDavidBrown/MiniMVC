<?php

class Cache extends Core_Library{
	function __construct(){
		parent::__construct();
	}
	
	function start(){
		//-1 is disabled
		if($this->settings['cache_time']<0){
			return;
		}
		$page = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$page = str_replace(array(".php","?c=","&m=","/","&cc",".."), ".", $page);
		$page = str_replace("..", ".", $page);
		$this->cachefile = 'app/cache/'.$page.'.html';

		$cachetime = $this->settings['cache_time']; //seconds
		
		//if the file exists and cache has not timed out
		if (file_exists($this->cachefile) && time() - $cachetime < filemtime($this->cachefile)) {
			include($this->cachefile);
			exit;
		}
		ob_start();
	}
	
	function stop(){
		if($this->settings['cache_time']<0){
			return;
		}
		$fp = fopen($this->cachefile, 'w');
		fwrite($fp, ob_get_contents());
		fclose($fp);
		ob_end_flush();
	}
	
	function clear(){
		$files = glob('app/cache/*'); // get all file names
		foreach($files as $file){ // iterate files 
			if(is_file($file)){
    			unlink($file); // delete file
			}
		}
	}
}