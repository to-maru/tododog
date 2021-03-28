<?php


namespace App\Services;


class Notifier
{
    public function notify($results)
    {
        info($results);
        $todo_update_order = new TodoUpdateOrder(688);
        var_dump($todo_update_order);
        exit;
    }
}
