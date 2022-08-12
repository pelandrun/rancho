<?php

namespace App\Model;

class TestModel 
{
	function __construct(){
		$this->test=[
			["nombre" => "Test 1"],
			["nombre" => "Test 2"]
		];

	}
	function getById($id){
		return $this->test["$id"];
	}
}
	
