<?php

namespace App\Model;

class TestModel 
{
	function __construct(){
		$this->test=[
			"Test 1",
			"Test 2"
		];
	}

	function getById($id){
		return $this->test[$id];
	}
}
	
