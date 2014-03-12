<?php

class Main extends Core_Controller{
	
	function __construct(){
		parent::__construct();
		$this->debug('main constructor');
	}
	
	function index(){
		$this->debug('main index');
    $this->view->load('main');
	}
}