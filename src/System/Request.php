<?php

namespace Src\System;

use Src\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    public function __construct()
    {
        $this->bootstrapSelf();
    }

    private function bootstrapSelf()
    {
        foreach($_SERVER as $key => $value) {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    private function toCamelCase($string): string
    {
        $result = strtolower($string);
        preg_match_all('/_[a-z]/', $result, $matches);
        foreach($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }
        return $result;
    }

    public function getBody(): array
    {
        return (array) json_decode(file_get_contents('php://input'), TRUE);
    }

    public function getId(): int
    {
        $array = explode('/', $_SERVER['REQUEST_URI']);
        return (int) end($array);
    }

    public function getToken(): string
    {
        if (isset($_SERVER['HTTP_AUTHORIZATION']) &&
            preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
            return $matches[1];
        }
        return false;
    }
}