<?php


namespace App\Services;


interface TodoApplicationApiClientInterface
{
    public function fetchAllProjects(): array;
    public function fetchAllTags(): array;
    public function fetchAllTodos(): array;
    public function fetchAllTodoDonetimes(): array;
    public function pushTodos(array $todo_update_orders): array;
}
