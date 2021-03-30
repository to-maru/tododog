<?php


namespace App\Services;


use App\Models\Todo;

class TodoUpdateOrder
{
//    const TODO_NAME_SEPARATOR = '/dog:';
//    const TAG_PREFIX = 'dog:';
    public Todo $original;

    public function __construct(
        public int $todo_id,
        public ?string $name = null,
        public ?array $tag_ids = null,
        public ?string $comment = null,
    )
    {
        $this->original = Todo::find($todo_id);
        if (is_null($this->name)) {
            $this->name = $this->original->name;
        }
        if (is_null($this->tag_ids)) {
            $this->tag_ids = json_decode($this->original->tag_ids, true);
        }
    }

    public function addFootnoteToName(string $footnote)
    {
        $this->name = $this->name . $footnote;
    }

    public function removeFootnoteFromName(string $footnote_prefix)
    {
        $this->name = explode($footnote_prefix, $this->name)[0];
    }

    public function addTags(array $tag_ids)
    {
        $this->tag_ids = array_unique(array_merge($this->tag_ids, $tag_ids));
    }

    public function removeTags(array $tag_ids)
    {
        $this->tag_ids = array_diff($this->tag_ids, $tag_ids);
    }

    public function existsNameUpdate(): boolean
    {
        return $this->name !== $this->original->name;
    }

    public function getTagsToAdd(): array
    {
        return array_diff($this->tag_ids, $this->original->tag_ids);
    }

    public function getTagsToRemove(): array
    {
        return array_diff($this->original->tag_id, $this->tag_ids);
    }

    public function existsTagUpdate(): boolean
    {
        return $this->getTagsToAdd() != $this->getTagsToRemove(); //todo: ちゃんと作る
    }

}