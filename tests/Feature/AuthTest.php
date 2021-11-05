<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_administrador_no_puede_autenticarse_de_nuevo(){
        $this->signIn();

        $this->get("/login")
            ->assertRedirect("/home");
    }

    public function test_un_administrador_puede_desloguearse(){
        $this->signIn();

        $this->get("/logout")
            ->assertRedirect("/login");
    }
}
