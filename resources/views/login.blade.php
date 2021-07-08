<x-app>
    <nav class="navbar sticky-top navbar-light" style="background-color: #CCBDB7;">
        <span class="navbar-brand font-weight-bold" style="font-family: 'Hiragino Kaku Gothic Std';color: #663114;">tododog</span>
        <a class="btn btn-danger" href="/api/auth/todoist/call">Todoistと連携する</a>
    </nav>
    <div class="text-center pt-5 pb-5">
        <h1 class="display-4" style="font-family: 'Hiragino Kaku Gothic Std W8';">tododogを飼って<br>楽しく習慣を身につけよう</h1>
        <p class="pt-3 font-weight-bold">tododogはTodoアプリと連携することで行動データを分析し習慣化の支援を行うツールです</p>
        <a class="btn btn-danger" href="/api/auth/todoist/call">Todoistと連携する</a>
    </div>
    <div class="text-center pt-5 pb-5">
        <img src="/images/app_abstruct.png" width="900">
    </div>
    <div class="pb-5">
        <h2 class="text-center font-weight-bold">習慣の継続日数や休止期間、直近の活動を使っているTodoアプリ上で振り返ろう</h2>
        <div class="align-content-center p-2" style="width:1000px;margin:0 auto;">
            <ul>
                <li>９日間連続達成中　→　「run:9d」とタスク名に追記されます</li>
                <li>５日間のお休み中　→　「sleep:5d」とタスク名に追記されます</li>
                <li>直近の１週間で２、５、６日前に達成した場合　→　「xoxxoox」とタスク名に追記されます （左が近い日付を表しています）</li>
            </ul>
        </div>
    </div>
    <div class="container pb-5 pt-5" style="width:1000px;margin:0 auto;">
        <div class="row">
            <div class="col ml-4 mr-4">
                <h5 class=" font-weight-bold">分析の対象を自由に設定</h5>
                <p>tododogが追記を行う対象をプロジェクトやタグで自由に指定することが出来ます。</p>
            </div>
            <div class="col ml-4 mr-4">
                <h5 class="font-weight-bold">チートデイに対応</h5>
                <p>たまにサボってしまった日があっても継続カウントを０にしないように設定することが可能です。</p>
            </div>
            <div class="col ml-4 mr-4">
                <h5 class="font-weight-bold">自動分析に対応</h5>
                <p>毎日自動で分析するように設定することが可能です。好きな時間帯に手動で分析を行うことにも対応しています。</p>
            </div>
        </div>
    </div>



</x-app>
