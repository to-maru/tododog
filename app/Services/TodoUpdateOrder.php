<?php


namespace App\Services;


use App\Models\Todo;

class TodoUpdateOrder
{
    public Todo $original;

    public function __construct(
        public int $todo_id,
        public ?string $name = null,
        public ?array $tag_ids = null,
        public ?string $comment = null,
    ) {
        $this->original = Todo::find($todo_id);
    }
}
