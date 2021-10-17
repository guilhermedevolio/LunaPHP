<?php

namespace Gui\Mvc\Controllers;

use Gui\Mvc\Core\Controller;

class HomeController extends Controller
{
    public function Index()
    {
       echo $this->request()->method();
    }

    public function Post()
    {
        echo "PostRequest";
    }

    public function Put()
    {
        echo "PutRequest";
    }

    public function Delete()
    {
        echo "DeleteRequest";
    }
}