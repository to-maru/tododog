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
    <x-nav :user="$user" />
    <div class="container-sm" style="max-width: 730px">
        <form method="POST">
            @csrf
            <div>
                <div class="mt-sm-4">
                    <div class="h3">STEP1: 習慣化したいことをTODOアプリに追加しよう</div>
                    <span>思いつかない場合は<a href="{{config('todoapp.todoist.todo_template_url')}}" style="font-family: 'Hiragino Kaku Gothic Std W8';">「良い習慣テンプレート」</a>の中から選んでみてください！！</span>
                </div>

                <div class="mt-sm-5">
                    <div class="h3">STEP2: 分析を行う対象や分析方法を決めよう</div>
                    <span>以下の設定を確認して、変えたいところがあれば編集しよう</span>
                    <div class="border border-info rounded p-2">
                        <div class="d-flex flex-row justify-content-between">
                            <div style="font-family: 'Hiragino Kaku Gothic Std W8';">分析設定</div>
                            <div>
                                <a href="/settings/analysis" class="btn btn-info btn-sm"
                                   type="submit">編集</a>
                            </div>
                        </div>
                        <div>
                            <span>　対象のプロジェクト：</span>
                            {{$setting_analysis->project_id == null ? '全てのプロジェクト' : ''}}
                            @foreach($projects as $key => $value)
                                {{$setting_analysis->project_id == $key ? $value : ''}}
                            @endforeach
                        </div>
                        <div>
                            <span>　対象のタグ：</span>
                            @if(!empty($setting_analysis->tag_ids))
                                @foreach($tags as $key => $value)
                                    {{in_array($key, $setting_analysis->tag_ids) ? $value . ' ': ''}}
                                @endforeach
                            @else
                                指定無し
                            @endif
                        </div>
                        <div>
                            <span>　チートデイ：</span>
                            {{$setting_analysis->cheat_day_enabled ? "有効（{$setting_analysis->cheat_day_interval}日に1回）" : '無効'}}
                        </div>
                        <div>
                            <span>　足跡の表示日数：</span>
                            直近{{$setting_analysis->footprints_number}}日間
                        </div>
                        <div>
                            <span>　1日の区切り：</span>
                            午前{{$setting_analysis->boundary_hour}}時
                        </div>
                        <div>
                            <span>　分析結果テキストのカスタマイズ：</span>
                            {{$setting_notification->footnote_custom_enabled ? "有り（{$setting_notification->footnote_custom_template}）" : '無し'}}
                        </div>
                    </div>
                </div>

                <div class="mt-sm-5 pb-sm-3">
                    <div class="h3">STEP3: 分析を実行してみよう</div>

                    <div class="p-sm-1 pt-sm-2 pb-sm-3 d-flex flex-row justify-content-between">
                        <div>
                            <div style="font-family: 'Hiragino Kaku Gothic Std W8';">手動実行</div>
                            <div>実行ボタンを押すと即座に分析を実行します。今すぐ試したい人はこちら。</div>
                        </div>
                        <div>
                            <a href="/app/run" class="btn btn-dark" type="submit">実行する</a>
                        </div>
                    </div>
                    <div class="p-sm-1 pb-sm-2 d-flex flex-row justify-content-between">
                        <div>
                            <div style="font-family: 'Hiragino Kaku Gothic Std W8';">自動実行</div>
                            <div>設定を有効にすると1日１回分析を実行します。継続したい人はこちら。</div>
                        </div>
                        <div>
                            @if($setting_analysis->autorun_enabled)
                                <a href="/app/autorun/?enable=false" class="btn btn-dark" type="submit">無効にする</a>
                            @else
                                <a href="/app/autorun/?enable=true" class="btn btn-outline-dark" type="submit">有効にする</a>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">最終実行日時　{{$synced_at ?? '---- / -- / --'}}</div>
                </div>

                <div class="border-dark border-top p-sm-1 pt-sm-2 mt-sm-5 pb-sm-5 d-flex flex-row justify-content-between">
                    <div>
                        <div style="font-family: 'Hiragino Kaku Gothic Std W8';">分析結果の消去</div>
                        <div>Todoアプリからtododogが追加した分析結果を消去します。</div>
                    </div>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#exampleModal">
                        分析結果を消去する
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">分析結果を消去しますか？</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div>Todoアプリからtododogが追加した分析結果（追記された文言）を消去します。</div>
                                    <div>分析結果を再び表示するためには再度分析を実行してください。</div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                                    <a class="btn btn-danger" href="/app/revert">分析結果を消去する</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div></div>
            </div>
        </form>
    </div>
</x-app>
