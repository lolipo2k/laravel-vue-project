<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'last_name' => 'required|string|min:3',
            'phone' => 'required|string|min:6',
            'role' => [
                'required',
                Rule::in([User::ROLE_CLIENT, User::ROLE_EMPLOYEE])
            ]
        ];
    }
}
