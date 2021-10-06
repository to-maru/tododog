<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class ApiPostingException extends Exception
{
    public function __construct(public Response $response, public string $class_name, public string $method_name)
    {

    }

    public function report()
    {
        Log::error('['.$this->class_name.'] '. $this->method_name . ' failure', ['response' => $this->response]);
    }
}
