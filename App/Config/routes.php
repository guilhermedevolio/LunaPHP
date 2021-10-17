<?php

use Gui\Mvc\Controllers\HomeController;
use Gui\Mvc\Core\Router;

$router = new Router();

$router->get('home', [HomeController::class, 'index']);
$router->get('teste/{nome}', [HomeController::class, 'teste']);

$router->dispatch();

