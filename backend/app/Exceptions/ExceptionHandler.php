<?php

namespace App\Exceptions;

use Exception;

class ExceptionHandler extends Exception
{
    protected $statusCode;

    public function __construct($message, $statusCode = 500)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
    }

    public function render()
    {
        return response()->json([
            "message" => $this->message,
            "status" => $this->statusCode
        ], $this->statusCode);
    }
}
