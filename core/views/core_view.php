<?php

class Core_View{
	
	function __construct(){
		
	}
	
	function load($view,$data = null){
		if($data){
			extract($data);
		}
		include('app/views/'.$view.'.php');
	}
	
}