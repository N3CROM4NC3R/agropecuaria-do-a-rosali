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
            "descripcion" => "required|string",
            "codigo_barras" => [
                "required",
                "string",
                Rule::unique("productos")->ignore($producto)
            ],
            "precio_venta" => "required|numeric"
        ];
    }
}
