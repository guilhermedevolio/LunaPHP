<?php

use Gui\Mvc\Core\Http\Response;

trait ResponseTrait {
    public function success(array $data = []) {
        return response();
    }
}