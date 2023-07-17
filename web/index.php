<?php

require_once dirname(__DIR__) . "/vendor/autoload.php";
require dirname(__DIR__) . "/inc/bootstrap.php";
if (PHP_SAPI === 'cli-server') {
    $_SERVER['PHP_SELF'] = '/' . basename(__FILE__);
	$url = parse_url(urldecode($_SERVER['REQUEST_URI']));
	$file = __DIR__ . $url['path'];
}
$relative_path=preg_replace('/index.php$/','',$_SERVER['PHP_SELF']);
$uri = explode( '/', explode('?',$_SERVER['REQUEST_URI'])[0] );
array_shift($uri);
$class="App\\Controller\\".ucfirst(strtolower($uri[0]))."Controller";
if (!class_exists($class)){	
	
	$endpoint = new App\Controller\BaseController;
}
$endpoint = new ${'class'}();