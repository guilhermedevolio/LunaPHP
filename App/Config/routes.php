<?php

use Gui\Mvc\Controllers\Admin\AdminController;
use Gui\Mvc\Core\Router;

$router = new Router();

//Admin Routes
$router->group('admin');    
$router->get('', [AdminController::class, 'index'], 'admin_auth');
$router->get('login', [AdminController::class, 'viewLogin']);
$router->post('auth/login', [AdminController::class, 'auth']);


$router->dispatch();

