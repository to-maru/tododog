<?php


namespace App\Services;


interface TodoApplicationApiClientInterface
{
    public function getAllProjects(): array;
    public function getAllTags(): array;
}
