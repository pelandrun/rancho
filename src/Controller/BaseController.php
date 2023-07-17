<?php

namespace App\Controller;

use \Nyholm\Psr7\Factory\Psr17Factory;

class BaseController
{

    public ?array $response = [
        "code" => "404",
        "success" => false,
        "message" => null,
        "result_len" => 0,
        "result" => []
    ];

    function __construct()
    {
        $this->psr17Factory = new Psr17Factory();
        $this->responseBody = $this->psr17Factory->createStream();
        // var_dump($this->response);
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        switch ($requestMethod) {
            case 'GET':
                $this->read();
                break;
            case 'POST':
                $this->create();
                break;
        }
    }

    /**
     * __call magic method.
     */
    public function __call($name, $arguments)
    {
        $response = $this->psr17Factory->createResponse(404)->withBody($this->responseBody);
        $this->emit($response);
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }

    /**
     * Get URI elements.
     *
     * @return array
     */
    protected function getUriSegments()
    {
        if (PHP_SAPI === 'cli-server') {

            $_SERVER['PHP_SELF'] = '/' . basename(__FILE__);
            $url = parse_url(urldecode($_SERVER['REQUEST_URI']));
            $file = __DIR__ . $url['path'];
        }
        $relative_path = preg_replace('/index.php$/', '', $_SERVER['PHP_SELF']);
        $uri = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);
        array_shift($uri);
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
    protected function getData()
    {
        return file_get_contents('php://input');
    }
    /**
     * Send API output.
     *
     * @param mixed  $data
     * @param string $httpHeader
     */
    protected function send404($msg)
    {
        $rd = [
            'code' => 404,
            'message' => $msg,
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

    // protected function sendResults($data){
    //     $header=[
    //         'Content-Type: application/json',
    //         'HTTP/1.1 '.$data['code'].' OK',
    //     ];
    //     $this->sendOutput(json_encode($data),$header);
    // }
    protected function sendOutput($data, $httpHeaders = array())
    {
        header_remove('Set-Cookie');

        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }

        echo $data . "\n";
        exit;
    }

    public function emit($response)
    {
        if (headers_sent()) {
            throw new \RuntimeException('Headers were already sent. The response could not be emitted!');
        }

        // Step 1: Send the "status line".
        $statusLine = sprintf(
            'HTTP/%s %s %s',
            $response->getProtocolVersion(),
            $response->getStatusCode(),
            $response->getReasonPhrase()
        );
        header($statusLine, TRUE); /* The header replaces a previous similar header. */

        // Step 2: Send the response headers from the headers list.
        foreach ($response->getHeaders() as $name => $values) {
            $responseHeader = sprintf(
                '%s: %s',
                $name,
                $response->getHeaderLine($name)
            );
            header($responseHeader, FALSE); /* The header doesn't replace a previous similar header. */
        }

        // Step 3: Output the message body.
        echo $response->getBody();
        exit();
    }
}
