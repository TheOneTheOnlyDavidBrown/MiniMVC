<?php

class CalculatorSample extends Core_Controller{
	
	function __construct(){
		parent::__construct();
		$this->data['page'] = basename(__FILE__, '.php');
	}
	
	function index(){
		
		global $cache;
		$cache->start();
		$this->data['page_title'] = 'Calculator';
		$this->view->load('layout/master',$this->data);
		$cache->stop();
	}
	
	//for ajax call
	function add(){
		
		if($this->request_method=="GET"){
			$a=$_GET['a'];
			$b=$_GET['b'];
		}
		else if($this->request_method=="POST"){
			$a=$_POST['a'];
			$b=$_POST['b'];
		}
		$m = $this->model->load('math');
		$sum = $m->add($a,$b);
		$return = array();
		if($sum==0){
			$return = array(
				'error' =>'sum is 0',
				'request' => $this->request_method
			);
		}
		else{
			$return = array(
				'sum' => $sum,
				'request' => $this->request_method
			);
		}
		if(json_encode($return)){
			echo json_encode($return);
		}
	}
}