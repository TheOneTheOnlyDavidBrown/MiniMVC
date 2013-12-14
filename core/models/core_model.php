<?php

class Core_Model{
	function __construct(){
		$this->model = $this;
	}
	
	function load($model){
		require('app/models/'.$model.'.php');
		return new $model;
	}
}