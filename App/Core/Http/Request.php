<?php

namespace Gui\Mvc\Core\Http;

class Request
{
    private $methodRequest;

    public function url()
    {
        return filter_input(INPUT_GET, 'url', FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function headers()
    {
        return getallheaders();
    }

    public function ip()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    public function get(string $name = null)
    {
        if ($name) {
            return filter_input(INPUT_GET, $name, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $this->methodRequest = "GET";
        return $this;
    }

    public function post(string $name = null)
    {
        if ($name) {
            return filter_input(INPUT_POST, $name, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $this->methodRequest = "POST";
        return $this;
    }

    public function all()
    {
        return $this->getRequestDataByMethod($this->methodRequest) ?? [];
    }

    private function json()
    {
        return json_decode(file_get_contents('php://input'), true);
    }


    private function getRequestDataByMethod(string $method)
    {
        switch ($method) {
            case 'GET':
                $data = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
                unset($data['url']);
                break;
            case 'POST':
                $data = ($json_data = $this->json())
                    ? $json_data
                    : filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS) ?? [];

                break;
        }

        return $data;
    }

}