<?php


namespace App\Services;


use App\Traits\TodoApplicationApiClientTrait;

class Notifier
{
    use TodoApplicationApiClientTrait;
    public $api_client;

    const FOOTNOTE_PREFIX = '/dog:';
    const FOOTNOTE_SEPARATOR = ', ';
    const TAG_PREFIX = 'dog:';

    public function notify($results)
    {
        $todo_update_orders = $this->getTodoUpdateOrders($results);
        var_dump($todo_update_orders);
        exit;
    }

    public function getTodoUpdateOrders($results): array
    {
        $all_created_tags = $this->getAllCreatedTags();
        $todo_update_orders = [];
        foreach ($results as $todo_id => $result) {
            $todo_update_orders[] = $this->getTodoUpdateOrder($todo_id, $result, $all_created_tags);
        }
        return $todo_update_orders;
    }

    public function getTodoUpdateOrder($todo_id, $result, $all_created_tags): TodoUpdateOrder
    {
        $todo_update_order = new TodoUpdateOrder($todo_id);
        $todo_update_order->removeFootnoteFromName(self::FOOTNOTE_PREFIX);
        $todo_update_order->addFootnoteToName($this->getFootnote($result));
        $todo_update_order->removeTags($all_created_tags);
        $todo_update_order->addTags($this->getTags($result));
        return $todo_update_order;
    }

    public function getFootnote($result): string
    {
        $footnote = self::FOOTNOTE_PREFIX;
        if ($result['running_days'] > 0) {
            $footnote = $footnote . 'run:' . $result['running_days'] . 'd';
        } elseif ($result['sleeping_days'] > 0)  {
            $footnote = $footnote . 'sleep:' . $result['sleeping_days'] . 'd';
        }
        $footnote = $footnote . self::FOOTNOTE_SEPARATOR . $result['foot_prints'];

        return $footnote;
    }

    public function getTags($result): array
    {
        return [];
    }

    public function getAllCreatedTags(): array
    {
        $tags = $this->getAllTagNames($this->api_client);
        return array_filter($tags, function($tag_name) {
            return strpos($tag_name, self::TAG_PREFIX) !== false;
        });
    }
}
