<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TagRequest extends Request
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
            'title' => 'required',
            'meta_title' => 'required',
            'meta_keywords' => 'required',
            'meta_description' => 'required',
        ];
    }

    /**
     * Custom messages
     * @return array
     */
    public function messages()
    {
        return [
          'title.required' => 'Титло це назва тегу, його треба заповнити',
          'meta_title.required' => 'Мета титло відображується на вкладці браузеру, необхідне для SEO',
          'meta_keywords.required' => 'Мета Ключові слова необхідні для SEO',
          'meta_description.required' => 'Мета Опис важливий для SEO його необхідно заповнити',
        ];
    }
}
