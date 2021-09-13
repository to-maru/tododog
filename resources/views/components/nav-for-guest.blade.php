<nav class="navbar sticky-top navbar-light" style="background-color: #CCBDB7;">
    <a class="navbar-brand logo" href="/">tododog</a>
    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#navForGuestModal">
        始める
    </button>
</nav>
<!-- Modal -->
<div class="modal fade" id="navForGuestModal" tabindex="-1" role="dialog" aria-labelledby="navForGuestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom:none;">
                <h5 class="modal-title" id="navForGuestModalLabel">ログイン</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <a class="btn btn-danger" href="/api/auth/todoist/call">Todoistでログイン</a>
            </div>
            <div class="modal-footer d-block">
                ログインボタンをクリックすることで、<a href="/terms" target="_blank" rel="noopener noreferrer">利用規約</a>と<a href="/privacy" target="_blank" rel="noopener noreferrer">プライバシーポリシー</a>に同意したものとみなします。
            </div>
        </div>
    </div>
</div>
