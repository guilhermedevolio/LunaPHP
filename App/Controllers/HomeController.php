<?php

namespace Gui\Mvc\Controllers;

use Gui\Mvc\Core\Controller;

class HomeController extends Controller
{
    public function Index()
    {
        $this->view->setPageTitle('Teste');
        $this->view->render('home/index');
    }

    public function Teste($nome)
    {
        echo $nome;
    }

    public function Post()
    {
        $postData = $this->request()->post()->all();
        var_dump($postData);
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