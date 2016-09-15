<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MenuRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;// TODO change it at false after some time
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
        ];


    }

    public function messages()
    {
        return [
          'url.required' => 'Fill the url, asshole',
        ];
    }
}
