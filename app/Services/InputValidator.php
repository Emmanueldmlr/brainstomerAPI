<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class InputValidator
{
    public static function registerValidation($data)
    {
        return Validator::make($data, [
            'address' => 'bail|required',
        ]);
    }

}
