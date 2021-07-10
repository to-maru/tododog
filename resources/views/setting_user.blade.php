<x-app>
    <x-slot name="style">
        html, body{
        height: 100vh;
        }
        h1 {
        font-family: 'Hiragino Kaku Gothic Std W8';
        }
        div {
        font-family: 'Hiragino Kaku Gothic Pro W6';
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
    <div class="container-md">
        <div class="ml-md-5 ml-sm-3 mr-md-5 mr-sm-3 mt-5 mb-5">
            <div class="pb-3">
                <h1>設定</h1>
            </div>
            <div class="card">
                <div class="card-header text-center">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link" href="./analysis">分析設定</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="./user">ユーザー設定</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <div class="p-sm-0 b-sm-0 pr-sm-5 ml-sm-5">
                            <div class="p-2 border-bottom border-dark"
                                 style="font-family: 'Hiragino Kaku Gothic Std W8';">ユーザー設定
                            </div>
                            <div class="pt-4 pb-4 p-sm-4 pl-lg-5 ml-lg-5 pr-lg-5 mr-lg-5">
                                <div class="p-sm-1 d-sm-flex flex-row justify-content-between">
                                    <p class="flex-fill">ユーザー名</p>
                                    <div class="flex-fill form-group  row justify-content-end">
                                        <input type="text" class="form-control col-9" id="cheat-day-interval"
                                               name="name" value={{$errors->has('name') ? old('name') : $user->name}}>
                                    </div>
                                </div>
                                @error('name')
                                <div class="text-right text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div class="float-right">
                                    <input class="btn btn-dark" type="submit" value="ユーザー情報を保存する">
                                </div>
                            </div>
                            <div class="p-2 mt-5 pt-5 mb-3 border-bottom border-dark"
                                 style="font-family: 'Hiragino Kaku Gothic Std W8';">ユーザー削除
                            </div>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#exampleModal">
                                ユーザー情報を消去する
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">本当にユーザー情報を消去しますか？</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div>
                                                Todoアプリ上のtododogが追加した分析結果および、本アプリで記録している全てのタスクと行動履歴を含むユーザーの全情報が消去されます。よろしいですか？
                                            </div>
                                            <div>
                                                ※連携しているTodoアプリ側で記録されているタスクと行動履歴は一切削除されません。<br>
                                                ※消去には数分の時間がかかります。
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                                            <a class="btn btn-danger" href="/settings/user/delete">ユーザーの全情報を消去する</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app>
