<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosCompradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_comprados', function (Blueprint $table) {
            $table->id();

            $table->integer("cantidad");
            $table->decimal("precio_unidad",9,2);

            $table->unsignedBigInteger("id_proveedor");
            $table->foreign("id_proveedor")
                ->references("id")
                ->on("proveedores")
                ->onDelete("cascade")
                ->onUpdate("cascade");

            $table->unsignedBigInteger("id_producto");
            $table->foreign("id_producto")
                ->references("id")
                ->on("productos")
                ->onDelete("cascade")
                ->onUpdate("cascade");


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos_comprados');
    }
}
