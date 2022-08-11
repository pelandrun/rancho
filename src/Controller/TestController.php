<?php

namespace App\Controller;
class TestController extends BaseController{
/*
        function __call($name,$argument){
                return "Llamando al método de objeto '$name' ". implode(', ', $a
rguments). "\n";
        }
*/
        public function __construct()
	{
                $this->test = new \App\Model\TestModel();
                parent::__construct();
        }

        function read(){
                $uri=$this->getUriSegments();
                if($acction=$uri[2]) // 2 = acction
                        switch($uri[2]){
                                case 'update':
                                $this->getupdate();
                                return;
                                case 'jobstatus':
                                $this->jobstatus();
                                return;
                        }
		if(!$rslt=$this->test->getById($uri[1])){
			$this->send404('no encotrado');
			return;
		}
		$this->sendOutput(
			json_encode(["test" => $rslt]),
                	array('Content-Type: application/json', 'HTTP/1.1 200 OK')
        	);
	}
}
