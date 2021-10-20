<?php

use Gui\Mvc\Controllers\HomeController;
use Gui\Mvc\Core\Router;

$router = new Router();

/**
 * Router System 
 * For set your routes follow the instructions below 
 * Create an instance of Gui\Mvc\Router (new Gui\Mvc\Core\Router()) and use this class methods below in the file
 * This Router contains 4 Http Methods (Get, Post, Put, Delete)
 *
 * For set route use : 
 * // $router->method($url, array(ReferenceController, controllerMethod));
 * 
 * If you want to use middlewares in your route, define them as the last parameter of the route, it can be an array with middlewares or a single middleware :
 * 
 * // One Middleware 
 * // $router->method($url, array(ReferenceController, controllerMethod) , 'middleware1');
 * // More Middlewares
 * // $router->method($url, array(ReferenceController, controllerMethod) , array('middleware1', 'middleware2'));
 * 
 * For define your middlewares , access Config/middlewares.php and set 'name_middleware' => MiddlewareReference::class 
 * 
 * Good Use:)
 */

$router->get('/', [HomeController::class, 'index']);
$router->get('home', [HomeController::class, 'index']);

$router->dispatch();

