<?php

namespace Gui\Mvc\Helpers;

class Redirect {
    public static function to(string $uri) {
        header('Location: '. $uri);
    }
}