<?php

namespace Gui\Mvc\Controllers;

use Gui\Mvc\Core\Controller;

class HomeController extends Controller
{
    public function Index()
    {
       $getData = $this->request()->get()->all();
       var_dump($getData );
    }

    public function Post()
    {
        $postData = $this->request()->post()->all();
        var_dump($postData );
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