<?php


namespace App\Services;


class TodoUpdateOrder
{
    public function __construct(
        public int $local_id,
        public ?string $name = null,
        public ?array $tag_ids = null,
        public ?string $comment = null,
    ) {

    }
}
