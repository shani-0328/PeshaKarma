<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
             
            'phone_number'=>'required|unique:users,phone_number',
            'phone_number'=>'required|regex:/(01)[0-9]{9}/',
            'email'=>'required|unique:users,email'
        ];
    }

    public function messages()
    {
        return [
            'email.unique:users,email' => 'Email is already take!',
         
        ];
    }
}
