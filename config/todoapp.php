<?php

return [

    'todoist' => [
        'url' => 'https://todoist.com',
        'client_id' => env('TODOIST_CLIENT_ID'),
        'client_secret' => env('TODOIST_CLIENT_SECRET'),
        'todo_template_url' => env('TODOIST_TEMPLATE_URL','https://todoist.com/API/v8.7/import/project_from_url?t_url=https%3A%2F%2Fd1aspxi4rjqbaz.cloudfront.net%2F3f96c2b366523b5f193c8835f97f05eb_%25E8%2589%25AF%25E3%2581%2584%25E7%25BF%2592%25E6%2585%25A3.csv'),
    ]

];
