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
        foreach ($rules as $key => $rule) {
            $exploded_rule = $this->getParsedRules($rule);

            foreach ($exploded_rule as $rule_) {

                if ($rule_ == "required" && (!isset($data[$key]) || empty($data[$key]))) {
                    $this->errors[$key][] = $this->validation_messages[$rule_]['error_message'];
                } else {
                    $call_validate = $this->call($rule_, $data[$key]);
                    if (!$call_validate) {
                        $this->errors[$key][] = $this->validation_messages[$rule_]['error_message'];
                    }
                }
            }
        }

        return $this;
    }

    private function call(string $validation, $value)
    {
        if (!method_exists($this->validations, $validation)) {
            throw new Exception('Validation $validation not found');
        }
        
        return $this->validations->$validation($value);
    }

    public function getParsedRules(string $rules): array
    {
        $newRules = array();

        if (strpos($rules, $this->separator)) {
            return explode($this->separator, $rules);
        }

        return (array) $rules;
    }

}
