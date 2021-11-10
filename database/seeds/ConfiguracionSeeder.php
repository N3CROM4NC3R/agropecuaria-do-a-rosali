<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ConfiguracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table("configuraciones")->insert([
           "nombre" => "iva",
           "valor" => "0"
       ]);
    }
}
