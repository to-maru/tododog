## 開発ルール
uriとコントローラー名は一致させる
`Route::get('/api/auth/todoist', Controllers\ApiAuthTodoistController::class . '@' . 'call');`

最下層のパスが動詞の場合はメソッドとして吸収する
`(例) Route::get('/api/auth/todoist/callback', Controllers\ApiAuthTodoistController::class . '@' . 'callback');`

リクエストクラス名は ${uri}${METHOD}Request とする
`(例) Route::post('/settings/analysis', ...) => SettingsAnalysisPostRequest.php`

## 運用ルール
### HEROKU
#### メンテナンスモード
- STG
  - `heroku maintenance:on -a stg-todo-dog`
  - `heroku maintenance:off -a stg-todo-dog`
    
- PRO
  - `heroku maintenance:on -a todo-dog`
  - `heroku maintenance:off -a todo-dog`
#### デプロイ
- STGデプロイ
  - Githubでdev→masterにマージ
    
- PROデプロイ
  - heroku上のPipelines画面でPromoteを実行する
    
#### DB更新 (Migration)
- STG DB
  - `heroku run php artisan migrate -a stg-todo-dog`

- PRO DB
  - `heroku run php artisan migrate -a todo-dog`
