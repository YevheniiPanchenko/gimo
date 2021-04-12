<?php

namespace Src\System;

use Src\Interfaces\RequestInterface;

class Router
{
    private $request;
    private $supported_http_methods = [
        "GET",
        "POST",
        "PUT",
        "DELETE"
    ];

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function __call($name, $args)
    {
        list($route, $method) = $args;

        if(!in_array(strtoupper($name), $this->supported_http_methods))
        {
            $this->invalidMethodHandler();
        }

        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    private function formatRoute($route): string
    {
        $result = rtrim($route, '/');
        if ($result === '') {
            return '/';
        }

        return $result;
    }

    private function invalidMethodHandler()
    {
        header("{$this->request->serverProtocol} 405 Method Not Allowed");
    }

    private function defaultRequestHandler()
    {
        header("{$this->request->serverProtocol} 404 Not Found");
    }

    public function resolve()
    {
        $method_dictionary = $this->{strtolower($this->request->requestMethod)};
        $formatted_route = $this->formatRoute($this->request->requestUri);
        $method = $method_dictionary[$formatted_route];
        if ($method) {
            echo call_user_func_array($method, [$this->request]);
            return;
        }
        $param_url = explode('/', $formatted_route);
        if (!$method && count($param_url) > 2) {
            $method =  $method_dictionary['/' . $param_url[1] . '/{id}'];
        } else {
            $this->defaultRequestHandler();
            return;
        }
        echo call_user_func_array($method, [$this->request]);
    }

    public function __destruct()
    {
        $this->resolve();
    }
}