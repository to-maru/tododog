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
        <div class="m-5 pb-5">
            <div class="pb-sm-3 d-flex flex-row justify-content-between align-items-end">
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
                            <div class="p-sm-2 border-bottom border-dark"
                                 style="font-family: 'Hiragino Kaku Gothic Std W8';">ユーザー設定
                            </div>
                            <div class="p-sm-4 m-sm-0 pl-sm-5 ml-sm-5 pr-sm-5 mr-sm-5">
                                <div class="p-sm-1 d-flex flex-row justify-content-between">
                                    <p class="flex-fill">ユーザー名</p>
                                    <div class="flex-fill form-group  row justify-content-end">
                                        <input type="text" class="form-control col-9" id="cheat-day-interval"
                                               name="name" value={{$errors->has('name') ? old('name') : $user->name}}>
                                    </div>
                                </div>
                                <div class="text-right text-danger">
                                    @error('name')
                                    {{ $message }}
                                    @enderror
                                </div>
                                <div class="float-right">
                                    <input class="btn btn-dark" type="submit" value="ユーザー情報を保存する">
                                </div>
                            </div>
                            <div class="p-sm-2 mt-5 pt-5 mb-3 border-bottom border-dark"
                                 style="font-family: 'Hiragino Kaku Gothic Std W8';">ユーザー削除
                            </div>
                            <a href="./user" class="btn btn-danger float-right" type="submit">ユーザー情報を消去する</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app>
