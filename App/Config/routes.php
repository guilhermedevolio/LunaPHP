<?php

use Gui\Mvc\Controllers\HomeController;
use Gui\Mvc\Core\Router;

$router = new Router();

$router->get('home/', [HomeController::class, 'index']);

$router->dispatch();

