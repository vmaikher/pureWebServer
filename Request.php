<?php

class Request
{
    private $request = null;
    public $method = null;
    public $uri = null;
    public $headers = null;

    public function __construct($requestData)
    {
        $this->request = $requestData;
        $this->parse();
    }

    public function parse()
    {
        $lines = explode("\n", $this->request);
        // method and uri
        list($this->method, $this->uri) = explode(' ', array_shift($lines));
        $this->uri = trim($this->uri, "/");

        $this->headers = array();

        foreach ($lines as $line) {
            // clean the line
            $line = trim($line);

            if (strpos($line, ': ') !== false) {
                list($key, $value) = explode(': ', $line);
                $this->headers[$key] = $value;
            }
        }
    }
}