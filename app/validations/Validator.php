<?php

class Validator
{
    //validation section Start()

    public function alphabetsNumbers($value, $input)
    {
        if (!preg_match('/^[A-Za-z0-9]*$/', $value)) {
            header('HTTP/1.0 422 Unprocessable Entity');
            $this->inputError($input, "Alphabets and numbers only: [A-Z a-z 0-9]");
        }
    }

    public function alphabetsNumbersSpecChars($value, $input)
    {
        if (!preg_match('/^[A-Za-zა-ჰ0-9-\[\]()., ]*$/', $value)) {
            header('HTTP/1.0 422 Unprocessable Entity');
            $this->inputError($input, "Alphabets, numbers and some special characters only: []().,- [A-Z a-z ა-ჰ 0-9]");
        }
    }

    public function isDecimal($value, $input)
    {
        if (!preg_match('/^[0-9]+(?:\.[0-9]{0,2})?$/', $value)) {
            header('HTTP/1.0 422 Unprocessable Entity');
            $this->inputError($input, "Please enter the value following format (ex: 1.05 or 1)");
        }
    }
    //validation section End()


    //return error section Start()

    public function inputError($inputName, $message)
    {
        echo json_encode([
            "error" => [
                "input" => $inputName,
                "message" => $message
            ]
        ]);
        exit;
    }

    //return error section End()

}
