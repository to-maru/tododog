## 運用ルール
uriとコントローラー名は一致させる
`Route::get('/api/auth/todoist', Controllers\ApiAuthTodoistController::class . '@' . 'call');`
最下層のパスが動詞の場合はメソッドとして吸収する
`(例) Route::get('/api/auth/todoist/callback', Controllers\ApiAuthTodoistController::class . '@' . 'callback');`
