<?php

class Users_Model extends Core_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getUsers(){
		global $settings;
		
		//where the database will be called via database driver
		//since i don't know what your database is named this is dummy data
		$users = array(
			array(
				'name'=>'tommy',
				'age'=>'28',
			),
			array(
				'name'=>'jane',
				'age'=>'26',
			),
		);
		return $users;
	}

}
