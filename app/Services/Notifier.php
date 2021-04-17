<?php


namespace App\Services;


use App\Traits\TodoApplicationApiClientTrait;

class Notifier
{
    use TodoApplicationApiClientTrait;
    public $api_client;
    public $all_created_tags;

    const FOOTNOTE_PREFIX = '\🐶';
    const FOOTNOTE_SEPARATOR = ', ';
    const TAG_PREFIX = 'Tododog:';

    public function notify($results)
    {
        $todo_update_orders = $this->getTodoUpdateOrders($results);
        $response = $this->updateTodos($this->api_client, $todo_update_orders);
        info(json_encode($response));
    }

    public function getTodoUpdateOrders($results): array
    {
        $this->all_created_tags = $this->getAllCreatedTags();
        $todo_update_orders = [];
        foreach ($results as $todo_id => $result) {
            $todo_update_orders[] = $this->getTodoUpdateOrder($todo_id, $result);
        }
        return $todo_update_orders;
    }

    public function getTodoUpdateOrder($todo_id, $result): TodoUpdateOrder
    {
        $tag_names = $this->convertAchievementsToTagNames($this->makeAchievements($result));
        $tag_ids = $this->getOrMakeTagIdsByTagNames($tag_names);
        $todo_update_order = new TodoUpdateOrder($todo_id);

        return $todo_update_order
            ->removeFootnoteFromName(self::FOOTNOTE_PREFIX)
            ->addFootnoteToName($this->getFootnote($result))
            ->removeTags(array_keys($this->all_created_tags))
            ->addTags($tag_ids);
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

    public function getOrMakeTagIdsByTagNames($tag_names)
    {
        $tag_ids = array();
        foreach ($tag_names as $tag_name) {
            $tag_id = array_search($tag_name, $this->all_created_tags, true);
            if ($tag_id === false) {
                $tag_id = $this->addTag($this->api_client, $tag_name);
                $this->all_created_tags[$tag_id] = $tag_name;
            }
            $tag_ids[] = $tag_id;
        }
        return $tag_ids;
    }

    public function convertAchievementsToTagNames($achievements): array
    {
        return array_map(function ($achievement) {
            return self::TAG_PREFIX . $achievement;
        }, $achievements);
    }

    public function makeAchievements($result): array
    {
        $achievements = array();

        if ($result['sleeping_days'] > 100) {
            $achievement[] = 'dead';
        }elseif ($result['sleeping_days'] > 30) {
            $achievement[] = 'half_dead';
        }

        if ($result['running_days'] > 100) {
            $achievement[] = 'excellent';
        }elseif ($result['running_days'] > 30) {
            $achievement[] = 'good';
        }
        return $achievements;
    }

    public function getAllCreatedTags(): array
    {
        $tags = $this->getAllTagNames($this->api_client);
        return array_filter($tags, function($tag_name) {
            return strpos($tag_name, self::TAG_PREFIX) !== false;
        });
    }
}
