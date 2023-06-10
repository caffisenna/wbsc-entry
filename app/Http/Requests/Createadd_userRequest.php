<?php

namespace App\Http\Requests;

use App\Models\add_user;
use Illuminate\Foundation\Http\FormRequest;

class Createadd_userRequest extends FormRequest
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
        return add_user::$rules;
    }

    public function messages()
    {
        return add_user::$messages;
    }
}
