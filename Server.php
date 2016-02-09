<?php
require_once('config.php');
require_once('Request.php');
require_once('Response.php');

class Server
{
    public $sock;
    public $requestData;

    public function __construct()
    {
        if (($sock = socket_create(AF_INET, SOCK_STREAM, 0)) === false) {
            echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
        }

        if (socket_bind($sock, IPADDRESS, PORT) === false) {
            echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        }
        echo $this->sock = $sock;
    }

    public function listen()
    {
        while (1) {
            // listen for connections
            socket_listen($this->sock);

            // try to get the client socket resource
            // if false we got an error close the connection and continue
            if (!$client = socket_accept($this->sock)) {
                socket_close($client);
                continue;
            }

            $this->requestData = socket_read($client, 1024);
            echo "request:" . $this->requestData;
            if ($this->requestData) {
                $responseData = $this->process();
                socket_write($client, $responseData, strlen($responseData));
            }
            // close the connetion so we can accept new ones
            socket_close($client);
        }
    }

    private function process()
    {
        $request = new Request($this->requestData);
        echo "uri: " . $request->uri . "\r\n";
        $response = new Response($request);
        return $response->getResponse();
    }
}