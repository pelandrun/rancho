<?php
//aqui van las constantes globales de configuracion
$Loader = new josegonzalez\Dotenv\Loader(__DIR__ . "/.env");
$Loader->parse()->define();
error_log(PERSAT_TOKEN);
error_log('aaa');
define("VARIABLE","VALOR");
define("URI_FILTER","/index.php$/");