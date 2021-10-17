<?php

namespace Gui\Mvc\Core;

use Gui\Mvc\Core\Http\Http;

abstract class Controller extends Http
{
    public function view(string $view, array $data = [])
    {
        echo $view;
    }
}