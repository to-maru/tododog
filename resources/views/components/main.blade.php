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
    <div class="container-fluid h-100">
        <div class="row h-100">
            <nav class="sidebar col-12 col-sm-4 col-md-3 col-lg-2 h-100 p-0 position-fixed top-0" style="background-color:#CCBDB7;">
                    {{ $nav }}
            </nav>
            <main class="col-12 offset-sm-4 offset-md-3 offset-lg-2 col-sm-8 col-md-9 col-lg-10">
                {{ $slot }}
            </main>
        </div>
    </div>
</x-app>