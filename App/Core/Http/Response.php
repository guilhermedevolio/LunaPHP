<?php

namespace Gui\Mvc\Core\Http;

class Response
{
    private array $data;
    private int $status = 200;

    public function setData(array $data) {
        $this->data = $data;
    }

    public function status(int $status): Response 
    {
        http_response_code($status);
        $this->status = $status;

        return $this;

    }

    public function json(array $data = [])
    {
        header('Content-type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}