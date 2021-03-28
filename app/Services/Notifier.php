<?php


namespace App\Services;


class Notifier
{
    public function notify($results)
    {
        info($results);
        $this->getTodoUpdateOrders($results);
        $todo_update_order = new TodoUpdateOrder(688);
        var_dump($todo_update_order);
        exit;
    }

    public function getTodoUpdateOrders($results)
    {
        foreach ($results as $todo_id => $result) {
            $this->getTodoUpdateOrder($todo_id, $result);
        }
    }

    public function getTodoUpdateOrder($todo_id, $result)
    {

    }
}
