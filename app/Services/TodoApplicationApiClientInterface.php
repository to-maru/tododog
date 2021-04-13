<?php


namespace App\Services;


interface TodoApplicationApiClientInterface
{
    public function getAllProjects(): array;
    public function getAllTags(): array;
    public function getAllTodos(): array;
    public function getAllTodoDonetimes(): array;
    public function updateTodos(array $todo_update_orders): array;
}
