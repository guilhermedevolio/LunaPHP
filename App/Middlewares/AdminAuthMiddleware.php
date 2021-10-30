<?php

namespace Gui\Mvc\Middlewares;

use Gui\Mvc\Helpers\Redirect;
use Gui\Mvc\Helpers\Session;

class AdminAuthMiddleware
{
    public function __construct()
    {
        if(!Session::get('auth_admin')) {
            Redirect::to('login');
        }
    }
}