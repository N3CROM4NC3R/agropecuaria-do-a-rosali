<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->decimal("precio_bruto", 9, 2)->nullable();
            $table->decimal("iva", 9, 2)->nullable();
            $table->decimal("precio_neto", 9, 2)->nullable();

            
            $table->unsignedBigInteger('id_cliente');
            $table->foreign("id_cliente")
                ->references("id")
                ->on("clientes")
                ->onDelete("cascade")
                ->onUpdate("cascade");

            $table->unsignedBigInteger('id_user');
            $table->foreign("id_user")
                ->references("id")
                ->on("users")
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
        Schema::dropIfExists('ventas');
    }
}
