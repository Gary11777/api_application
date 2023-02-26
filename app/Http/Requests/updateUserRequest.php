<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //'token' => 'required',
            //'Authorization' => 'required',
            //"token" => "exists:oauth_access_tokens,id",
            'name' => 'required',
            'email' => 'nullable|email',
            'password' => 'nullable'
        ];
    }
}
