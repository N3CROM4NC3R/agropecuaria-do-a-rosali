<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class ProductoUpdateRequest extends FormRequest
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
        
        $producto = request()->route("producto");


        return [
            "descripcion" => "required_without_all:codigo_barras,precio_venta|string",
            "codigo_barras" => [
                "required_without_all:descripcion,precio_venta",
                "string",
                Rule::unique("productos")->ignore($producto)
            ],
            "precio_venta" => "required_without_all:descripcion,codigo_barras|numeric"
        ];
    }
}
