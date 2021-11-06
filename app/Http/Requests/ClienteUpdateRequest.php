<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClienteUpdateRequest extends FormRequest
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

        $cliente = request()->route("cliente");

        return [
            "nombre" => "required_without_all:nombre,email,cedula,direccion,telefono|string",
            "apellido" => "required_without_all:cedula,apellido,email,direccion,telefono|string",
            "cedula" => "required_without_all:nombre,apellido,email,direccion,telefono|string|unique:clientes",
            "email" => [
                "required_without_all:nombre,apellido,cedula,direccion,telefono",
                "email",
                Rule::unique("clientes")->ignore($cliente)
            ],
            "direccion" => "nullable|string",
            "telefono" => "nullable|string"
        ];
    }
}
