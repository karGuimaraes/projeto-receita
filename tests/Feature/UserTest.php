<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserTest extends TestCase
{
    public function test_sign_not_found()
    {
        $response = $this->post('/api/user/sign/');
        $response
            ->assertStatus(422)
            ->assertJsonStructure(['errors']);
    }
    public function test_sign()
    {
        $user = User::factory()->make();
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password
        ];
        $response = $this->post('/api/user/sign/', $data);
        $response
            ->assertStatus(204);
    }
    public function test_login_validation()
    {
        $user = User::factory()->make();
        $response = $this->get('/api/user/login/?email='.$user->email.'&password=invalida');
        $response
            ->assertStatus(401)
            ->assertExactJson(['Usuário ou senha inválido']);
    }
    public function test_login()
    {
        $user = User::factory()->state(['password' => bcrypt('123')])->create();
        $response = $this->get('/api/user/login/?email='.$user->email.'&password=123');
        $response
            ->assertStatus(200);
    }

    public function test_logout_token()
    {
        $response = $this->get('/api/user/logout/');
        $response->assertStatus(401);
    }
    public function test_logout()
    {
        # Para gerar um token
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('GET', '/api/user/logout/', []);
        $response
            ->assertStatus(204);
    }
}
