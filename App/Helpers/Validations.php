<?php

namespace Gui\Mvc\Helpers;

class Validations
{
    public function email($val): bool
    {
        return (bool) filter_var($val, FILTER_VALIDATE_EMAIL);
    }

    public function int($val): bool
    {
        return (bool) is_integer($val);
    }

    public function required($val): bool
    {
        return (bool) (!is_null($val) && !empty($val));
    }
}