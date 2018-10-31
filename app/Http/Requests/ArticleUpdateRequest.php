<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ArticleUpdateRequest extends FormRequest
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
            'title' => 'required|max:255',
            'description' => 'required',
            'user_id' => 'required|exists:users,id',
            'image' => 'required|image'
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        //throw new HttpResponseException(response($validator->errors()->all(), 422));
    }
}
