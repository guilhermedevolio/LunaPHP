<?php

namespace Gui\Mvc\Core\Http;

class Request
{
    public function url()
    {
        return filter_input(INPUT_GET, 'url', FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}