<?php


namespace App\Http\Services;


interface TodoApplicationApiClientInterface
{
    public function getAllProjects(): array;
    public function getAllTags(): array;
}
