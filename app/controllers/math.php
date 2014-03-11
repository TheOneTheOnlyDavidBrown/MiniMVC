<?php

class Math extends Core_Controller{
	
	function __construct(){
		parent::__construct();
		$this->debug('math fn ');
	}
	
	function mymath(){

		$this->debug('my math ');
		$this->debug($this);
		
		$this->m = $this->model->load('math');
		
		$this->debug($this);
		$data = array();
		$data['mynum'] = $this->m->add(8,6);
		$data['mynumsub'] = $this->m->subtract(8,4);
		print_r($data);
		$this->debug('my math ');
		$this->view->load('calcout',$data);
	}
	
	function index(){
		
	}
}