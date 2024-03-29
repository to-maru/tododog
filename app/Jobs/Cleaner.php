<?php

namespace App\Jobs;

use App\Models\Todo;
use App\Models\User;
use App\Services\Notifier;
use App\Services\TodoUpdateOrder;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Synchronizer;
use App\Services\Analyzer;
use Illuminate\Support\Facades\Log;


class Cleaner implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600;

    public function __construct(
        public User $user
    ) {
        //
    }

    public function handle(
        Synchronizer $synchronizer,
        Notifier $notifier,
    )
    {
        Log::info('['.self::class.'] '.'start', ['user_id' => $this->user->id]);
        $synchronizer->api_client = $synchronizer->getApiClient($this->user->todo_application);
        $synchronizer->pullTodosAndDonetimes($this->user->todo_application);
        $notifier->api_client = $notifier->getApiClient($this->user->todo_application);

        $all_created_tags = $notifier->fetchAllCreatedTags();
        $todos = $this->user->todo_application->todos;
        $todo_update_orders = $todos->map(function ($todo) use ($all_created_tags){
            $todo_update_order = new TodoUpdateOrder($todo);
            $todo_update_order->removeFootnoteFromName(Notifier::FOOTNOTE_PREFIX);
            $todo_update_order->removeTags(array_keys($all_created_tags));
            return $todo_update_order;
        })->toArray();

        $response = $notifier->pushTodos($notifier->api_client, $todo_update_orders);
        //$response = $notifier->pushDeletedTags($notifier->api_client, array_keys($all_created_tags));
        //scope=>data:delete が必要.
        $synchronizer->pullTodosAndDonetimes($this->user->todo_application);
        Log::info('['.self::class.'] '.'end', ['user_id' => $this->user->id]);
    }
}
