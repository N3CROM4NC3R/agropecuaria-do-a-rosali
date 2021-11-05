<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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


        $user = request()->route("user");

        return [
            "name" => "string",
            "apellido" => "string",
            "email"    => [
                "nullable",
                "email",
                Rule::unique("users")->ignore($user)
            ],
            "cedula" => [
                "nullable",
                "string",
                Rule::unique("users")->ignore($user)
            ],
            "password" => "required_without_all:name,apellido,email,cedula|nullable|string",
            "repeatPassword" => "required_without_all:name,apellido,email,cedula|same:password"
        ];
    }
}
