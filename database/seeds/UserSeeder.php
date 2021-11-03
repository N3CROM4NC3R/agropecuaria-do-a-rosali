<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
            "name" => "administrador",
            "email" => "administrador@mail.com",
            "apellido" => "super",
            "cedula" => "00000000",
            "password" => bcrypt("Secret123"),
        ]);
    }
}
