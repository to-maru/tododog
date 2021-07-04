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
                            <a class="nav-link active" href="./analysis">分析設定</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./user">ユーザー設定</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <form method="POST">
                        @csrf
                        <div class="p-sm-0 b-sm-0 pr-sm-5 ml-sm-5">
                            <div class="p-sm-2 border-bottom border-dark"
                                 style="font-family: 'Hiragino Kaku Gothic Std W8';">分析対象
                            </div>
                            <div class="p-sm-4 m-sm-0 pl-sm-5 ml-sm-5 pr-sm-5 mr-sm-5">
                                <div class="p-sm-1 d-flex flex-row justify-content-between">
                                    <p class="flex-fill">プロジェクト</p>
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
                                    <p class="flex-fill">ラベル</p>
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
                                 style="font-family: 'Hiragino Kaku Gothic Std W8';">分析設定
                            </div>
                            <div class="p-sm-4 m-sm-0 pl-sm-5 ml-sm-5 pr-sm-5 mr-sm-5">
                                <div>
                                    <div class="p-sm-1 d-flex flex-row justify-content-between">
                                        <p class="flex-fill">チートデイ</p>
                                        <div class="custom-control custom-switch">
                                            <input class="custom-control-input" type="checkbox"
                                                   id="cheat-day-enabled"
                                                   name="cheat_day_enabled" {{($errors->has('cheat_day_enabled') ? old('cheat_day_enabled') : $setting->cheat_day_enabled) ? 'checked="checked"' : ''}}>
                                            <label class="custom-control-label" for="cheat-day-enabled">
                                                {{--                                                        If it's enabled, the running days will not be reset even if you take a break once in a while.--}}
                                            </label>
                                        </div>
                                    </div>
                                    @error('cheat_day_enabled')
                                    <div class="text-right text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div>
                                    <div class="p-sm-1 d-flex flex-row justify-content-between">
                                        <p class="flex-fill">チートデイ間隔</p>
                                        <div class="flex-fill form-group row justify-content-end">
                                            <input type="number" class="form-control col-3" id="cheat-day-interval"
                                                   name="cheat_day_interval"
                                                   value={{$errors->has('cheat_day_interval') ? old('cheat_day_interval') : $setting->cheat_day_interval}} placeholder="Enter Number">
                                            <span>　日に1回</span>
                                        </div>
                                    </div>
                                    @error('cheat_day_interval')
                                    <div class="text-right text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div>
                                    <div class="p-sm-1 d-flex flex-row justify-content-between">
                                        <p class="flex-fill">足跡の表示日数</p>
                                        <div class="flex-fill form-group row justify-content-end">
                                            <span>直近　</span>
                                            <input type="number" class="form-control col-3" id="footprints-number"
                                                   name="footprints_number"
                                                   value={{$errors->has('footprints_number') ? old('footprints_number') : $setting->footprints_number}} placeholder="Enter Number">
                                            <span>　日間</span>
                                        </div>
                                    </div>
                                    @error('footprints_number')
                                    <div class="text-right text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div>
                                    <div class="p-sm-1 d-flex flex-row justify-content-between">
                                        <p class="flex-fill">1日の区切り</p>
                                        <div class="flex-fill form-group row justify-content-end">
                                            <select class="form-control col-6" id="project" name="boundary_hour">
                                                <option value="0" {{$setting->boundary_hour == 0 ? 'selected="selected"' : ''}}>
                                                    午前0時
                                                </option>
                                                <option value="4" {{$setting->boundary_hour == 4 ? 'selected="selected"' : ''}}>
                                                    午前4時
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input class="btn btn-dark float-right" type="submit" value="設定を保存する">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app>
