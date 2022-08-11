<?php
namespace App\Controller;

class BaseController
{
    function __construct() {
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        switch($requestMethod){
                case 'GET':
                        $this->read();
                case 'POST':
                        $this->create();
        }
    }
    /**
     * __call magic method.
     */
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }

    /**
     * Get URI elements.
     *
     * @return array
     */
    protected function getUriSegments()
    {
        $relative_path=preg_replace('/index.php$/','',$_SERVER['SCRIPT_NAME']);
        $uri=str_replace($relative_path,'',$_SERVER['REQUEST_URI']);
        // $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );

        return $uri;
    }

    /**
     * Get querystring params.
     *
     * @return array
     */
    protected function getQueryStringParams()
    {
        return parse_str($_SERVER['QUERY_STRING'], $query);
    }
    protected function getData(){
        return file_get_contents('php://input');
    }
    /**
     * Send API output.
     *
     * @param mixed  $data
     * @param string $httpHeader
     */
    protected function send404($msg){
        $rd=[
            'code'=>404,
            'mesage'=>$msg,
        ];
        $this->sendOutput(
            json_encode($rd),
            array('Content-Type: application/json', 'HTTP/1.1 404 OK')
        );

    }

    /**
    *code int
    *message string
    *success bool
    *---------
    *result_legt int
    *results array
    */
    protected function sendResults($data){
        $header=[
            'Content-Type: application/json',
            'HTTP/1.1 '.$data['code'].' OK',
        ];
        $this->sendOutput(json_encode($data),$header);
    }
    protected function sendOutput($data, $httpHeaders=array())
    {
        header_remove('Set-Cookie');

        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }

        echo $data."\n";
        exit;
    }
}
