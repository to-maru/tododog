<nav class="navbar navbar-light" style="background-color: #CCBDB7;">
    <a class="navbar-brand font-weight-bold" style="font-family: 'Hiragino Kaku Gothic Std';color: #663114;" href="/">tododog</a>
    <div class="dropdown pr-2">
        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
            </svg>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" style="font-family: 'Hiragino Kaku Gothic Std W3';" href="/settings/user">{{$user->name}}</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" style="font-family: 'Hiragino Kaku Gothic Std W3';" href="/settings/analysis">設定</a>
            <a class="dropdown-item" style="font-family: 'Hiragino Kaku Gothic Std W3';" href="https://forms.gle/aMFfWTnXNoJhxMjd9">お問い合わせ</a>
            <a class="dropdown-item" style="font-family: 'Hiragino Kaku Gothic Std W3';" href="https://forms.gle/X5avmeJcnB7dNqUy9">フィードバック</a>
            <a class="dropdown-item" style="font-family: 'Hiragino Kaku Gothic Std W3';" href="https://twitter.com/to_maru815">開発者</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" style="font-family: 'Hiragino Kaku Gothic Std W3';" href="/user/sign_out">ログアウト</a>
        </div>
    </div>
</nav>
