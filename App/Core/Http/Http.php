<?php

namespace Gui\Mvc\Core\Http;

abstract class Http
{
    public function request(): Request
    {
        return (new Request());
    }

    public function response(): Response
    {
        return (new Response());
    }
}