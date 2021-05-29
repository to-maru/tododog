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
{{--    <x-slot name="nav">--}}
{{--        <div class="h-100 d-flex flex-column justify-content-between">--}}
{{--            <div>--}}
{{--                <div class="text-center">--}}
{{--                            <span class="navbar-brand font-weight-bold mt-2 mb-5"--}}
{{--                                  style="font-family: 'Hiragino Kaku Gothic Std';color: #663114;">Tododog</span>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <div class="p-sm-2 pl-sm-4" style="background-color: #9E7D6C;">Routine Watcher</div>--}}
{{--                    <div class="p-sm-2 pl-sm-4">Resource Watcher</div>--}}
{{--                    <div class="p-sm-2 pl-sm-4">Somedays Watcher</div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="pb-2">--}}
{{--                <div>--}}
{{--                    <div class="p-sm-2 pl-sm-4">Notification</div>--}}
{{--                    <div class="p-sm-2 pl-sm-4">FeedBack</div>--}}
{{--                </div>--}}
{{--                <div class="dropright p-sm-2 pl-sm-4 pb-sm-4">--}}
{{--                    <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"--}}
{{--                       data-offset="-200,10">--}}
{{--                        {{ $user->name }}--}}
{{--                    </a>--}}
{{--                    <div class="dropdown-menu">--}}
{{--                        <a class="dropdown-item" style="font-family: 'Hiragino Kaku Gothic Std W3';" href="#">Action</a>--}}
{{--                        <a class="dropdown-item" style="font-family: 'Hiragino Kaku Gothic Std W3';" href="#">Another--}}
{{--                            action</a>--}}
{{--                        <a class="dropdown-item" style="font-family: 'Hiragino Kaku Gothic Std W3';" href="#">Something--}}
{{--                            else here</a>--}}
{{--                        <div class="dropdown-divider"></div>--}}
{{--                        <a class="dropdown-item" style="font-family: 'Hiragino Kaku Gothic Std W3';"--}}
{{--                           href="/user/sign_out">Sign Out</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </x-slot>--}}
    <nav class="navbar navbar-light" style="background-color: #CCBDB7;">
        <span class="navbar-brand font-weight-bold" style="font-family: 'Hiragino Kaku Gothic Std';color: #663114;">tododog</span>
        <a class="btn btn-danger" href="/api/auth/todoist">Login with Todoist</a>
    </nav>
    <div class="container-md">
        <div class="m-5">
            <div class="pr-sm-5 d-flex flex-row justify-content-between align-items-end">
                <h1>設定</h1>
            </div>
            <div class="mt-5">
                <form method="POST">
                    @csrf
                    <div class="p-sm-0 b-sm-0 pr-sm-5 br-sm-5">
                        <div class="p-sm-2 border-bottom border-dark"
                             style="font-family: 'Hiragino Kaku Gothic Std W8';">Filter
                        </div>
                        <div class="p-sm-4 m-sm-0 pl-sm-5 ml-sm-5 pr-sm-5 mr-sm-5">
                            <div class="p-sm-1 d-flex flex-row justify-content-between">
                                <p class="flex-fill">Project</p>
                                <div class="flex-fill form-group">
                                    <select class="form-control" id="project" name="project_id">
                                        <option
                                            value="" {{$setting->project_id == null ? 'selected="selected"' : ''}}>
                                            全てのプロジェクト
                                        </option>
                                        @foreach($projects as $key => $value)
                                            <option
                                                value="{{$key}}" {{$setting->project_id == $key ? 'selected="selected"' : ''}}>{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="p-sm-1 d-flex flex-row justify-content-between">
                                <p class="flex-fill">Label</p>
                                <div class="flex-fill overflow-auto" style="max-height: 200px;">
                                    @foreach($tags as $key => $value)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$key}}"
                                                   id="tag{{$key}}" name="tag_ids[]"
                                            @if(!is_null($setting->tag_ids))
                                                {{in_array($key, $setting->tag_ids) ? 'checked="checked"' : ''}}
                                                @endif
                                            >
                                            <label class="form-check-label" for="tag{{$key}}">
                                                {{$value}}
                                            </label>

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="p-sm-2 border-bottom border-dark"
                             style="font-family: 'Hiragino Kaku Gothic Std W8';">Setting
                        </div>
                        <div class="p-sm-4 m-sm-0 pl-sm-5 ml-sm-5 pr-sm-5 mr-sm-5">
                            <div class="p-sm-1 d-flex flex-row justify-content-between">
                                <p class="flex-fill">CheatDay System</p>
                                <div class="custom-control custom-switch">
                                    <input class="custom-control-input" type="checkbox"
                                           id="cheat-day-enabled"
                                           name="cheat_day_enabled" {{$setting->cheat_day_enabled ? 'checked="checked"' : ''}}>
                                    <label class="custom-control-label" for="cheat-day-enabled">
                                        {{--                                                        If it's enabled, the running days will not be reset even if you take a break once in a while.--}}
                                    </label>
                                </div>
                            </div>
                            <div class="p-sm-1 d-flex flex-row justify-content-between">
                                <p class="flex-fill">CheatDay Interval</p>
                                <div class="flex-fill form-group">
                                    <input type="number" class="form-control" id="cheat-day-interval"
                                           name="cheat_day_interval"
                                           value={{$setting->cheat_day_interval}} placeholder="Enter Number">
                                </div>
                            </div>
                            <div class="p-sm-1 d-flex flex-row justify-content-between">
                                <p class="flex-fill">Number Of Footprints</p>
                                <div class="flex-fill form-group">
                                    <input type="number" class="form-control" id="footprints-number"
                                           name="footprints_number"
                                           value={{$setting->footprints_number}} placeholder="Enter Number">
                                </div>
                            </div>
                        </div>
                        <input class="btn btn-dark float-right" type="submit" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app>
