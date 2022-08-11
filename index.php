<?php
require_once "./vendor/autoload.php";
require __DIR__ . "/inc/bootstrap.php";


$relative_path=preg_replace('/index.php$/','',$_SERVER['SCRIPT_NAME']);
$uri=$_SERVER['REQUEST_URI'];
$uri=str_replace($relative_path,'',$_SERVER['REQUEST_URI']);
$uri = explode( '/', $uri );
$class="App\\Controller\\".ucfirst(strtolower($uri[0]))."Controller";
if (!class_exists($class)){	
	$endpoint = new App\Controller\BaseController;
}
$endpoint = new ${'class'}();

