<?php

namespace Gui\Mvc\Helpers;

class Hash {
    public $authConfig;

    public function __construct()
    {
        $this->authConfig = require_once __DIR__ . '/../Config/auth.php';
    }

    public function password(string $password): string
    {
        return password_hash($password, $this->authConfig['crypt_method']);
    }

    public function check(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}