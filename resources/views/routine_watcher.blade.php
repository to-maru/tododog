<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}}
        </style>

        <style>
            html, body{
                height: 100vh;
            }
            h1 {
                font-family: 'Hiragino Kaku Gothic Std W8';
            }
            div {
                font-family: 'Hiragino Kaku Gothic Pro W6';
            }
        </style>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body class="antialiased">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <nav class="sidebar col-12 col-sm-2 sm:h-100 p-0" style="background-color: #CCBDB7;">
                    <div class="h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="text-center">
                                <span class="navbar-brand font-weight-bold mt-2 mb-5" style="font-family: 'Hiragino Kaku Gothic Std';color: #663114;">Tododog</span>
                            </div>
                            <div>
                                <div class="p-sm-2 pl-sm-4" style="background-color: #9E7D6C;">Routine Watcher</div>
                                <div class="p-sm-2 pl-sm-4">Resource Watcher</div>
                                <div class="p-sm-2 pl-sm-4">Somedays Watcher</div>
                            </div>
                        </div>
                        <div class="pb-2">
                            <div>
                                <div class="p-sm-2 pl-sm-4">Notification</div>
                                <div class="p-sm-2 pl-sm-4">FeedBack</div>
                            </div>
                            <div class="dropright p-sm-2 pl-sm-4 pb-sm-4">
                                <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="-200,10">
                                    {{ $user->name }}
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" style="font-family: 'Hiragino Kaku Gothic Std W3';" href="#">Action</a>
                                    <a class="dropdown-item" style="font-family: 'Hiragino Kaku Gothic Std W3';" href="#">Another action</a>
                                    <a class="dropdown-item" style="font-family: 'Hiragino Kaku Gothic Std W3';" href="#">Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" style="font-family: 'Hiragino Kaku Gothic Std W3';" href="/user/sign_out">Sign Out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                <main class="col-10">
                    <div class="container-md">
                        <div class="m-5">
                            <h1>Routine Watcher</h1>
                            <div class="mt-5">
                                <form method="POST">
                                    @csrf
                                    <div class="p-sm-0 b-sm-0 pr-sm-5 br-sm-5">
{{--                                        <div class="p-sm-2" style="font-family: 'Hiragino Kaku Gothic Std W8';">Setting</div>--}}
{{--                                        <div class="p-sm-0 pl-sm-5 pr-sm-5 m-sm-0 ml-sm-5 mr-sm-5">--}}
{{--                                            <div class="p-sm-2 d-flex flex-row justify-content-between">--}}
{{--                                                <div class="custom-control custom-switch">--}}
{{--                                                    <input type="checkbox" class="custom-control-input" id="customSwitch1">--}}
{{--                                                    <label class="custom-control-label" for="customSwitch1">Toggle this switch element</label>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="p-sm-2">Label</div>--}}
{{--                                        </div>--}}
                                    </div>
                                    <div class="p-sm-0 b-sm-0 pr-sm-5 br-sm-5">
                                        <div class="p-sm-2 border-bottom border-dark" style="font-family: 'Hiragino Kaku Gothic Std W8';">Filter</div>
                                        <div class="p-sm-4 m-sm-0 pl-sm-5 ml-sm-5 pr-sm-5 mr-sm-5">
                                            <div class="p-sm-1 d-flex flex-row justify-content-between">
                                                <p class="flex-fill">Project</p>
                                                <div class="flex-fill form-group">
                                                    <select class="form-control" id="project" name="project_id">
                                                        <option value="" {{$setting->project_id == null ? 'selected="selected"' : ''}}>全てのプロジェクト</option>
                                                        @foreach($projects as $key => $value)
                                                            <option value="{{$key}}" {{$setting->project_id == $key ? 'selected="selected"' : ''}}>{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="p-sm-1 d-flex flex-row justify-content-between">
                                                <p class="flex-fill">Label</p>
                                                <div class="flex-fill">
                                                    @foreach($tags as $key => $value)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="{{$key}}" id="tag{{$key}}" name="tag_ids[]"
                                                                @if(!is_null($setting->tag_ids))
                                                                    {{in_array($key, $setting->tag_ids) ? 'checked="checked"' : ''}}
                                                                @endif>
                                                            <label class="form-check-label" for="tag{{$key}}">
                                                                {{$value}}
                                                            </label>

                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input class="btn btn-dark" type="submit" value="Save">
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
