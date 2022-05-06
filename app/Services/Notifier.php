<?php


namespace App\Services;


use App\Models\Todo;
use App\Models\UserSettingNotification;
use App\Traits\TodoApplicationApiClientTrait;
use Carbon\Carbon;

class Notifier
{
    use TodoApplicationApiClientTrait;

    const FOOTNOTE_PREFIX = '\🐶';
    const TAG_PREFIX = 'Tododog:';
    const ALIASES = [
        'running_days' => null,
        'sleeping_days' => null,
        'days' => 'days',
        'foot_prints' => 'print',
        'total_times' => 'all',
        'max_monthly_times' => 'maxmo',
        'this_month_times' => 'mo',
    ];
    const FOOTNOTE_BASE_DEFAULT = '{days}, {print}, all:{all}';

    public $api_client;
    public $all_created_tags;

    private $setting;

    public function notify($todo_results, UserSettingNotification $setting)
    {
        $this->setting = $setting;
        $todo_update_orders = $this->makeTodoUpdateOrders($todo_results);
        $response = $this->pushTodos($this->api_client, $todo_update_orders);
    }

    public function makeTodoUpdateOrders($todo_results): array
    {
        $this->all_created_tags = $this->fetchAllCreatedTags();
        $todo_update_orders = [];
        foreach ($todo_results as $todo_result) {
            $todo_update_orders[] = $this->makeTodoUpdateOrder($todo_result['todo'], $todo_result['result']);
        }
        return $todo_update_orders;
    }

    public function makeTodoUpdateOrder(Todo $todo, array $result): TodoUpdateOrder
    {
        $tag_names = $this->convertAchievementsToTagNames($this->makeAchievements($result));
        $tag_ids = $this->makeTagIdsByTagNames($tag_names);
        $todo_update_order = new TodoUpdateOrder($todo);
        $date = $result['exist_today_done'] ? Carbon::tomorrow() : Carbon::today();

        return $todo_update_order
            ->updateDueDate($date->toDateString())
            ->removeFootnoteFromName(self::FOOTNOTE_PREFIX)
            ->addFootnoteToName($this->makeFootnote($result))
            ->removeTags(array_keys($this->all_created_tags))
            ->addTags($tag_ids);
    }

    public function makeFootnote($result): string
    {
        $footnote_base = self::FOOTNOTE_BASE_DEFAULT;
        if ($this->setting->footnote_custom_enabled) {
            $footnote_base = $this->setting->footnote_custom_template;
        }
        $footnote = $this->buildFootnoteFromBase($footnote_base, $result);
        $footnote = self::FOOTNOTE_PREFIX . $footnote;
        return $footnote;
    }

    public function buildFootnoteFromBase($footnote_base, $result)
    {
        $footnote = $footnote_base;
        foreach (self::ALIASES as $result_key => $alias) {
            if (is_null($alias)) {
                continue;
            }
            $footnote = str_replace("{{$alias}}", $result[$result_key], $footnote);
        }
        return $footnote;
    }

    public function makeTagIdsByTagNames($tag_names)
    {
        $tag_ids = array();
        foreach ($tag_names as $tag_name) {
            $tag_id = array_search($tag_name, $this->all_created_tags, true);
            if ($tag_id === false) {
                $tag_id = $this->pushNewTag($this->api_client, $tag_name);
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

    public function fetchAllCreatedTags(): array
    {
        $tags = $this->fetchAllTagNames($this->api_client);
        return array_filter($tags, function($tag_name) {
            return strpos($tag_name, self::TAG_PREFIX) !== false;
        });
    }
}
