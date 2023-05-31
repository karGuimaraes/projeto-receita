<?php

namespace Tests\Feature;

use App\Models\Receita;
use App\Models\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ReceitaTest extends TestCase
{
    public function test_index_is_empty()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer '. $token)
            ->json('GET', '/api/receitas/receita');
        $response
            ->assertOk()
            ->assertJsonFragment(['total' => 0]);
    }

    public function test_index()
    {
        Receita::factory(5)->create();
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer '. $token)
            ->json('GET', '/api/receitas/receita');
        $response
            ->assertOk()
            ->assertJsonFragment(['total' => 5]);
    }

    public function test_index_if_filter_not_found()
    {

    }

    public function test_index_with_filter()
    {

    }

    public function test_store_with_failed_validation()
    {

    }

    public function test_store()
    {

    }

    public function test_show_if_object_not_found()
    {

    }

    public function test_show()
    {

    }

    public function test_update_if_object_not_found()
    {

    }

    public function test_update_with_failed_validation()
    {

    }

    public function test_update()
    {

    }

    public function test_destroy_if_object_not_found()
    {

    }

    public function test_destroy()
    {

    }

    public function test_restore_if_object_not_found()
    {

    }

    public function test_restore()
    {

    }
}
