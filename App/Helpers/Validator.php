<?php

namespace Gui\Mvc\Helpers;

class Validator
{
    private $separator = "/";
    private array $errors = [];
    private Validations $validations;
    private array $validation_messages;

    public function __construct()
    {
        $this->validations = (new Validations);
        $this->validation_messages = require_once __DIR__ . '/../Config/validations_errors.php';
    }

    public function errors()
    {
        return $this->errors;
    }


    public function make(array $data, array $rules)
    {
        foreach ($data as $key => $value) {

            if (isset($rules[$key])) {
                $rules_ = $this->getValidations($rules[$key]);
                foreach ($rules_ as $rule) {
                    $call_validate = $this->call($rule, $value);

                    if ($rule == "required") {
                        if (!$call_validate) {
                            $this->errors[$key][] = $this->validation_messages[$rule]['error_message'];
                            break;
                        }
                    }

                    if (!$call_validate) {
                        $this->errors[$key][] = $this->validation_messages[$rule]['error_message'];
                    }
                }
            }

        }

        return $this;
    }

    private function call(string $validation, $value)
    {
        if (method_exists($this->validations, $validation)) {
            return $this->validations->$validation($value);
        } else {
            die("Validation $validation not found");
        }
    }

    public function getValidations(string $rules)
    {
        $newRules = array();

        if (strpos($rules, $this->separator)) {
            return explode($this->separator, $rules);
        }

        return (array)$rules;
    }

}