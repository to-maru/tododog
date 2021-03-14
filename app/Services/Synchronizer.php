<?php


namespace App\Services;


use App\Models\TodoApplication;
use App\Traits\TodoApplicationApiClientTrait;

class Synchronizer
{
    use TodoApplicationApiClientTrait;
    public $api_client;

    public function __construct()
    {

    }

    public function syncronizeTodo()
    {
        $todos = $this->getAllTodos($this->api_client);
        info($todos);

    }
}
