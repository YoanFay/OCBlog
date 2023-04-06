<?php

namespace App\Src\Validator;

class Validator
{


    /**
     * @param mixed $parameter parameter
     * @return bool
     */
    public function validateIsNotEmpty($parameter): bool
    {
        if (empty($parameter) === FALSE && strlen($parameter) > 0) {
            return true;
        }

        return false;

    }//end validateIsNotEmpty()

    
    /**
     * @param mixed $parameter parameter
     * @return bool
     */
    public function validateIsString($parameter): bool
    {
        if (is_string($parameter) === TRUE) {
            return true;
        }

        return false;
    }

}
