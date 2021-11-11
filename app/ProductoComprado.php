<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoComprado extends Model
{
    protected $table = "productos_comprados";
    protected $fillable = ["cantidad", "precio_unidad","id_proveedor", "id_producto"];
    

    public function producto()
    {
        return $this->belongsTo("App\Producto", "id_producto");
    }

    public function proveedor()
    {
        return $this->belongsTo("App\Proveedor", "id_proveedor");
    }

}
