<?php

class users extends Core_Controller{
	
	function __construct(){
		parent::__construct();
		$this->debug('users construct ');
		$this->data = array();
		$this->data['page'] = basename(__FILE__, '.php');
		if(isset($_GET['cc'])){
			global $cache;
			$cache->clear();
			echo 'cc';
		}
	}
	
	function getUsers(){
		global $cache;
		$cache->start();
		$this->debug('set users ');
		
		$this->m = $this->model->load('users_model');
		$this->data['users'] = $this->m->getUsers();
		
		$this->view->load('layout/master',$this->data);
		$cache->stop();
		my_log_error('my error message');
		
		
	}
	
	function index(){
		$this->debug('users index ');
	}
}