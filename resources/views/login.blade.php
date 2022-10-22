<x-app>
    <x-slot name="style">
        html, body{
        height: 100vh;
        }
        h1 {
        font-family: 'Hiragino Kaku Gothic Std W8', Verdana, Roboto, "Droid Sans", "游ゴシック", YuGothic, "メイリオ", Meiryo, "ヒラギノ角ゴ ProN W3", "Hiragino Kaku Gothic ProN", "ＭＳ Ｐゴシック", sans-serif;
        }
        div {
        font-family: 'Hiragino Kaku Gothic Std W3', Verdana, Roboto, "Droid Sans", "游ゴシック", YuGothic, "メイリオ", Meiryo, "ヒラギノ角ゴ ProN W3", "Hiragino Kaku Gothic ProN", "ＭＳ Ｐゴシック", sans-serif;
        }
        a, span {
        font-family: Verdana, Roboto, "Droid Sans", "游ゴシック", YuGothic, "メイリオ", Meiryo, "ヒラギノ角ゴ ProN W3", "Hiragino Kaku Gothic ProN", "ＭＳ Ｐゴシック", sans-serif;
        }
        p {
        font-family: Verdana, Roboto, "Droid Sans", "游ゴシック", YuGothic, "メイリオ", Meiryo, "ヒラギノ角ゴ ProN W3", "Hiragino Kaku Gothic ProN", "ＭＳ Ｐゴシック", sans-serif;
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
    <x-nav-for-guest />
    <div class="text-center pt-5 pb-5">
        <h1 class="display-4">tododogを飼って<br>楽しく習慣を身につけよう</h1>
        <p class="pt-3 ml-2 mr-2  font-weight-bold">tododogはTodoアプリと連携することで行動を分析し習慣化の支援を行うツールです</p>
        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#navForGuestModal">
            始める
        </button>
    </div>
    <div class="text-center pt-5 pb-5">
        <img src="/images/app_abstruct.png" class="img-fluid" width="900">
    </div>
    <div class="pb-5">
        <h2 class="ml-3 mr-3 text-center font-weight-bold">習慣の継続日数や休止期間、直近の活動を使っているTodoアプリ上で振り返ろう</h2>
        <div class="d-flex justify-content-center">
            <div class="m-2" style="display:inline-block;">
                <ul>
                    <li class="mb-sm-1 mb-2">９日間連続達成中　→　「run:9d」とタスク名に追記されます</li>
                    <li class="mb-sm-1 mb-2">５日間のお休み中　→　「sleep:5d」とタスク名に追記されます</li>
                    <li>直近の１週間で２、５、６日前に達成した場合　→　「xoxxoox」とタスク名に追記されます （左が近い日付を表しています）</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container pb-5 pt-5" style="max-width:1000px;margin:0 auto;">
        <div class="row">
            <div class="col-sm-4 col-12 pl-4 pr-4 mb-2">
                <h5 class=" font-weight-bold">分析の対象を自由に設定</h5>
                <p>tododogが追記を行う対象をプロジェクトやタグで自由に指定することが出来ます。</p>
            </div>
            <div class="col-sm-4 col-12 pl-4 pr-4 mb-2">
                <h5 class="font-weight-bold">チートデイに対応</h5>
                <p>たまにサボってしまった日があっても継続カウントを０にしないように設定することが可能です。</p>
            </div>
            <div class="col-sm-4 col-12 pl-4 pr-4 mb-2">
                <h5 class="font-weight-bold">自動分析に対応</h5>
                <p>毎日自動で分析するように設定することが可能です。好きな時間帯に手動で分析を行うことにも対応しています。</p>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        document.cookie = "js-text=xxx; max-age=3600";
        document.cookie = "js-textA=xxx; max-age=3600";
        document.cookie = "js-text4=xxx; max-age=3600; domain=stg-todo-dog.herokuapp.com; path=/";
        document.cookie = "js-text4A=xxx; max-age=3600; domain=.stg-todo-dog.herokuapp.com; path=/";
        document.cookie = "js-text5=xxx; max-age=3600; domain=herokuapp.com; path=/";
        document.cookie = "js-text5A=xxx; max-age=3600; domain=.herokuapp.com; path=/";


</script>

    <x-footer />
</x-app>
