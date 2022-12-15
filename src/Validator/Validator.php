<?php

namespace App\Src\Validator;

class Validator
{

    public function intBetween($parameter, $min, $max)
    {

        if ($parameter >= $min && $parameter <= $max) {
            return true;
        }

        return false;

    }

    public function validateIsNotEmpty($parameter){
        if (!empty($parameter) && strlen($parameter) > 0){
            return true;
        }

        return false;
    }

    public function validateIsString($parameter){
        if (is_string($parameter)){
            return true;
        }

        return false;
    }

    public function validateIsGranted($parameter, $length){
        if (strlen($parameter) <= $length){
            return true;
        }

        return false;
    }

}