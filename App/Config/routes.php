<?php

$router = new \Gui\Mvc\Core\Router();

$router->get('home', 'HomeController@Index');
$router->post('home', 'HomeController@Post');
$router->delete('home', 'HomeController@Delete');

$router->dispatch();

