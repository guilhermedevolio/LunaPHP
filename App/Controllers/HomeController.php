<?php

namespace Gui\Mvc\Controllers;

use Gui\Mvc\Core\Config;
use Gui\Mvc\Core\Controller;
use Gui\Mvc\Enums\HttpStatusEnum;
use Gui\Mvc\Helpers\Validator;

class HomeController extends Controller
{
    public function Index()
    {
        return response()->status(HttpStatusEnum::UNAUTHORIZED)->json(['status' => 1, 'msg' => 'OI']);

        $request = $this->request()->get()->all();

        $validator = (new Validator())->make($request, [
            'email' => 'required/email/int',
            'idade' => 'int'
        ]);

        if($validator->errors()) {
            var_dump($validator->errors());
        }

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