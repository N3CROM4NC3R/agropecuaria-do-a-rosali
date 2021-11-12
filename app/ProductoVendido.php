<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoVendido extends Model
{
    protected $table = "productos_vendidos";
    protected $fillable = ["id_venta", "descripcion", "codigo_barras", "precio", "cantidad"];

    public function scopeDatetimeGreaterThan($query, $datetime){

        return $query->where("created_at",">=","$datetime");
    }



    public function venta()
    {
        return $this->belongsTo("App\Venta", "id_venta");
    }
}
