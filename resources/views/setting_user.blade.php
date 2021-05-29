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
                    <div class="alert alert-warning" role="alert">
                        今後追加予定
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>
