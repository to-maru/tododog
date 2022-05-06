<?php


namespace App\Services;


use App\Models\Todo;

class TodoUpdateOrder
{
    public function __construct(
        public Todo $original,
        public ?string $name = null,
        public ?array $tag_ids = null,
        public ?string $comment = null,
        public ?array $due = null,
    )
    {
        $this->original->tag_ids = json_decode($this->original->tag_ids, true);

        if (is_null($this->name)) {
            $this->name = $this->original->name;
        }
        if (is_null($this->tag_ids)) {
            $this->tag_ids = $this->original->tag_ids;
        }
        if (is_null($this->due)) {
            $this->due = $this->original->due;
        }
    }

    public function addFootnoteToName(string $footnote)
    {
        $this->name = $this->name . $footnote;
        return $this;
    }

    public function removeFootnoteFromName(string $footnote_prefix)
    {
        $this->name = explode($footnote_prefix, $this->name)[0];
        return $this;
    }

    public function addTags(array $tag_ids)
    {
        $this->tag_ids = array_unique(array_merge($this->tag_ids, $tag_ids));
        return $this;
    }

    public function removeTags(array $tag_ids)
    {
        $this->tag_ids = array_diff($this->tag_ids, $tag_ids);
        return $this;
    }

    public function existsNameUpdate(): bool
    {
        return $this->name !== $this->original->name;
    }

    public function getTagsToAdd(): array
    {
        return array_diff($this->tag_ids, $this->original->tag_ids);
    }

    public function getTagsToRemove(): array
    {
        return array_diff($this->original->tag_ids, $this->tag_ids);
    }

    public function existsTagUpdate(): bool
    {
        return $this->getTagsToAdd() != $this->getTagsToRemove(); //todo: ちゃんと作る
    }

    public function updateDueDate(string $date)
    {
        $this->due['date'] = $date;
        return $this;
    }

    public function existsDueUpdate(): bool
    {
        logger(print_r($this->original->due, true));
        logger(print_r($this->due, true));
        return array_diff($this->original->due, $this->due) != array_diff($this->due, $this->original->due);
    }

    public function existsAnyUpdate(): bool
    {
        return $this->existsNameUpdate() || $this->existsTagUpdate() || $this->existsDueUpdate();
    }

}
