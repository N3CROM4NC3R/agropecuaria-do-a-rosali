<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductoCompradoUpdateRequest extends FormRequest
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
            "cantidad" => "required_without_all:precio_unidad,id_proveedor,id_producto|integer|gt:0",
            "precio_unidad" => "required_without_all:cantidad,id_proveedor,id_producto|numeric|gt:0",
            "id_proveedor" => "required_without_all:cantidad,precio_unidad,id_producto|exists:proveedores,id",
            "id_producto" => "required_without_all:cantidad,precio_unidad,id_proveedor|exists:productos,id"
        ];
    }
}
