<x-app>
    <x-slot name="style">
        html, body{
        height: 100vh;
        }
        h1 {
        font-family: 'Hiragino Kaku Gothic Std W8';
        }
        div {
        font-family: 'Hiragino Kaku Gothic Std W3';
        }
        ::-webkit-scrollbar {
        -webkit-appearance: none;
        width: 7px;
        }
        ::-webkit-scrollbar-thumb {
        border-radius: 4px;
        background-color: rgba(0,0,0,.5);
        box-shadow: 0 0 1px rgba(255,255,255,.5);
        }
    </x-slot>
    <nav class="navbar navbar-light" style="background-color: #CCBDB7;">
        <span class="navbar-brand font-weight-bold" style="font-family: 'Hiragino Kaku Gothic Std';color: #663114;">tododog</span>
        <div class="dropleft">
            <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
               data-offset="-200,10">
                {{ $user->name }}
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" style="font-family: 'Hiragino Kaku Gothic Std W3';" href="#">Action</a>
                <a class="dropdown-item" style="font-family: 'Hiragino Kaku Gothic Std W3';" href="#">Another
                    action</a>
                <a class="dropdown-item" style="font-family: 'Hiragino Kaku Gothic Std W3';" href="#">Something
                    else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" style="font-family: 'Hiragino Kaku Gothic Std W3';"
                   href="/user/sign_out">Sign Out</a>
            </div>
        </div>
    </nav>
    <div class="container-sm" style="max-width: 730px">
        <form method="POST">
            @csrf
            <div class="p-sm-0 b-sm-0">
                <div class="p-sm-4 m-sm-0 pl-sm-5 pr-sm-5">
                    <div class="border border-info rounded mt-5 mb-5 p-2">
                        <div class="d-flex flex-row justify-content-between">
                            <div style="font-family: 'Hiragino Kaku Gothic Std W8';">分析設定</div>
                            <div>
                                <a href="/settings/analysis" class="btn btn-info btn-sm"
                                   type="submit">Edit</a>
                            </div>
                        </div>
                        <div>
                            <span>　対象のプロジェクト：</span>
                            {{$setting->project_id == null ? '全てのプロジェクト' : ''}}
                            @foreach($projects as $key => $value)
                                {{$setting->project_id == $key ? $value : ''}}
                            @endforeach
                        </div>
                        <div>
                            <span>　対象のタグ：</span>
                            @foreach($tags as $key => $value)
                                {{in_array($key, $setting->tag_ids) ? $value . ' ': ''}}
                            @endforeach
                        </div>
                        <div>
                            <span>　チートデイ：</span>
                            {{$setting->cheat_day_enabled ? "有効（{$setting->cheat_day_interval}日に1回）" : '無効'}}
                        </div>
                        <div>
                            <span>　足跡の表示日数：</span>
                            直近{{$setting->footprints_number}}日間
                        </div>
                    </div>
                    <div class="p-sm-1 d-flex flex-row justify-content-between">
                        <div>
                            <div style="font-family: 'Hiragino Kaku Gothic Std W8';">自動実行</div>
                            <div>設定を有効にすると1日１回分析を実行します</div>
                        </div>
                        <div>
                        @if($setting->autorun_enabled)
                            <a href="/app/autorun/?enable=false" class="btn btn-dark" type="submit">無効にする</a>
                        @else
                            <a href="/app/autorun/?enable=true" class="btn btn-outline-dark" type="submit">有効にする</a>
                        @endif
                        </div>
                    </div>
                    <div class="p-sm-1 pt-sm-4 pb-sm-4 d-flex flex-row justify-content-between">
                        <div>
                            <div style="font-family: 'Hiragino Kaku Gothic Std W8';">手動実行</div>
                            <div>実行ボタンを押すと即座に分析を実行します</div>
                        </div>
                        <div>
                            <a href="/app/run" class="btn btn-dark" type="submit">実行する</a>
                        </div>
                    </div>
                    <div class="text-right">最終実行日時　{{$synced_at ?? '---- / -- / --'}}</div>
                    <div class="border-dark border-top p-sm-1 pt-sm-2 mt-sm-5 mb-sm-5 d-flex flex-row justify-content-between">
                        <div>
                            <div style="font-family: 'Hiragino Kaku Gothic Std W8';">分析結果の消去</div>
                            <div>Todoアプリからtododogが追加した分析結果を消去します。<br>
                                分析結果を再び表示するためには再度分析を実行してください。
                            </div>
                        </div>
                        <div>
                            <a href="/app/revert" class="btn btn-danger"
                               type="submit">分析結果を消去する</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app>
