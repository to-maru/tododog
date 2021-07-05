<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsAnalysisPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cheat_day_enabled' => 'nullable|in:on',
            'cheat_day_interval' => 'required|integer|between:1,365',
            'footprints_number' => 'required|integer|between:0,31',
            'boundary_hour' => 'required|integer|between:0,23',
            'footnote_custom_enabled' => 'nullable|in:on',
            'footnote_custom_template' => 'required_if:footnote_custom_enabled,on', //todo: 犬の絵文字を弾きたい
        ];
    }
}
