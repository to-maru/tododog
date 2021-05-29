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
