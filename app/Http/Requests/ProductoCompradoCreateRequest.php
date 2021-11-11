<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoCompradoCreateRequest extends FormRequest
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
            "cantidad"      => "required|integer|gt:0",
            "precio_unidad" => "required|numeric|gt:0",
            "id_proveedor"  => "required|exists:proveedores,id",
            "id_producto"   => "required|exists:productos,id"
        ];
    }
}
