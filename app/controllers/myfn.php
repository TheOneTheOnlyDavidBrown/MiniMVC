<?php

class myfn extends Core_Controller{
	
	function __construct(){
		parent::__construct();
		$this->debug('myfn ');
	}
	
	function mymath(){
		$this->debug('my math ');
		
		$this->m = $this->model->load('math');

		$data = array();
		$data['mynum'] = $this->m->add(8,6);
		$data['mynumsub'] = $this->m->subtract(8,4);
		
		$this->view->load('calcout',$data);
	}
	
	function index(){
		
	}
}