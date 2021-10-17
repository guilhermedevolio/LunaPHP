<?php

namespace Gui\Mvc\Core;

use Gui\Mvc\Core\Http\Http;

abstract class Controller extends Http
{
    public View $view;

    public function __construct()
    {
        $this->view = (new View());
    }


}