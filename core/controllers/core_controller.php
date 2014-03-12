<?php

class Core_Controller{
	
	function __construct(){
		global $settings;
		$this->settings = $settings;
		
		require_once('core/views/core_view.php');
		$this->view = new Core_View;
		//so that $this->view->load() can be used in a view
		$this->view->view = $this->view;
		
		require_once('core/models/core_model.php');
		$this->model = new Core_Model;
		
		$this->request_method = $_SERVER['REQUEST_METHOD'];
		
	}
	
	function debug($input){
		if($this->settings['debug']){
			echo $input.'<br/>';
		}
	}
	
}