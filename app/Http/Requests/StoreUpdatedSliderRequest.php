<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreUpdatedSliderRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //TODO change it to false after some time
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'url'   => 'required',
            'image' => 'max:5',
            'image.*' => 'mimes:jpg,jpeg,png|max:5000',
        ];
    }

    public function messages()
    {
        return [
            'url.required' => 'Fill the url',
            'image.*.mimes' => 'Image must be one of this file types jpg,jpeg,png'
        ];
    }
}
