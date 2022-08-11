<?php

namespace App\Controller;

class ReferenciaController extends BaseController{
/*
        function __call($name,$argument){
                return "Llamando al método de objeto '$name' ". implode(', ', $a
rguments). "\n";
        }
*/
        public function __construct()
        {
                $this->model = new ReferenciaModel();
                $this->awxjob = new AwxjobModel();
                $this->uri=$this->getUriSegments();
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
	}
}
