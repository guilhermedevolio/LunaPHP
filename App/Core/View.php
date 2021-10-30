<?php

namespace Gui\Mvc\Core;

class View
{
    public $data;
    public $pageTitle;

    public function setPageTitle(string $name)
    {
        $this->pageTitle = $name;
    }

    public function render($view, array $data = [])
    {
        $this->data = $data;

        $file = __DIR__ . '/../Views/' . $view . '.phtml';

        if (file_exists($file)) {
            require_once $file;
        }
    }

    public function load(string $component = null)
    {
        $file = __DIR__ . '/../Views/' . $component . '.phtml';
        require_once $file;
    }


}