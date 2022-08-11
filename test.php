<?php

class test 
{
	function __construct($val=null){
		$this->mivar=$val;
	}
	function showvar(){
		echo $this->mivar;
	}
	function setvar($val){
		$this->mivar="inicial";
	}
}

$o = new test;
$u = new test('objeto u');
$o->showvar();
$u->showvar();
