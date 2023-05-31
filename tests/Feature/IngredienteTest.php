<?php

namespace Tests\Feature;

use App\Models\Ingrediente;
use App\Models\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class IngredienteTest extends TestCase
{
    /**
     *  Testa a rota index sem token de acesso
     */
    public function test_index_token()
    {
        $response = $this->get('/api/receitas/ingrediente/');
        $response->assertStatus(401);
    }

    /**
     * Testa a rota index quando não há nenhuma informação de pessoas no banco
     */
    public function test_index_is_empty()
    {
        # Para gerar um token
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('GET', '/api/receitas/ingrediente/', []);
        $response
            ->assertOk()
            ->assertJsonFragment(['total' => 0]);
    }

    /**
     * Testa a rota index localizando 5 resultados
     */
    public function test_index()
    {
        Ingrediente::factory(5)->create();
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('GET', '/api/receitas/ingrediente/', []);
        $response
            ->assertOk()
            ->assertJsonFragment(['total' => 5]);
    }

    /**
     * Testa a rota de store para validar ao passar nenhuma informação
     */
    public function test_store_with_failed_validation()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->json('POST', '/api/receitas/ingrediente/', []);
        $response
            ->assertStatus(422)
            ->assertJsonStructure(['errors']);
    }

    /**
     * Testa a rota store passando informações corretas
     */
    public function test_store()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $ingrediente = Ingrediente::factory()->make();

        $response = $this->withHeader('Authorization', 'Bearer '. $token)
            ->json('POST', '/api/receitas/ingrediente/', ['nome' => $ingrediente->nome]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'message', 'status', 'data']);

    }

    /**
     *  testa a rota show quando não encontra resultado
     */
    public function test_show_if_object_not_found()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer '. $token)
            ->json('GET', '/api/receitas/ingrediente/0');

        $response
            ->assertStatus(404);
    }

    /**
     * testa a rota show
     */
    public function test_show()
    {
        $ingrediente = Ingrediente::factory()->create();

        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer '. $token)
            ->json('GET', '/api/receitas/ingrediente/'.$ingrediente->id);

        $response
            ->assertStatus(200)
            ->assertExactJson(['id' => $ingrediente->id, 'nome' => $ingrediente->nome]);
    }

    /**
     * Teste rota update quando não encontra o valor do id
     */
    public function test_update_if_object_not_found()
    {
        $ingrediente = Ingrediente::factory()->make();
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer '. $token)
            ->json('GET', '/api/receitas/ingrediente/0', ['nome' => $ingrediente->nome]);

        $response
            ->assertStatus(404);
    }

    /**
     * Teste rota update quando há erro de request
     */
    public function test_update_with_failed_validation()
    {
        $ingrediente = Ingrediente::factory()->create();
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer '. $token)
            ->json('PUT', '/api/receitas/ingrediente/'.$ingrediente->id, []);

        $response
            ->assertStatus(422)
            ->assertJsonStructure(['errors']);
    }
    /**
     * testa a rota update com sucesso
     */
    public function test_update()
    {
        $ingrediente = Ingrediente::factory()->create();
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer '. $token)
            ->json('PUT', '/api/receitas/ingrediente/'.$ingrediente->id, ['nome' => 'nome ingrediente']);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'message', 'status', 'data']);
    }

    /**
     *  testa a rota destroy excluindo uma informação que não existe
     */
    public function test_destroy_if_object_not_found()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer '. $token)
            ->json('DELETE', '/api/receitas/ingrediente/0');

        $response
            ->assertStatus(404);
    }
    /**
     *  testa a rota destroy com sucesso
     */
    public function test_destroy()
    {
        $ingrediente = Ingrediente::factory()->create();
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer '. $token)
            ->json('DELETE', '/api/receitas/ingrediente/'.$ingrediente->id);

        $response
            ->assertStatus(204);
    }

    /**
     * testa a rota restore tentando restaurar um id que não existe
     */
    public function test_restore_if_object_not_found()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer '. $token)
            ->json('PUT', '/api/receitas/ingrediente/0/restore/');

        $response
            ->assertStatus(404);
    }

    /**
     * testa a rota restore tentando restaurar um id que não existe
     */
    public function test_restore()
    {
        $ingrediente = Ingrediente::factory()->create();
        $ingrediente->destroy($ingrediente->id);
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer '. $token)
            ->json('PUT', '/api/receitas/ingrediente/'. $ingrediente->id.'/restore');

        $response
            ->assertStatus(204);
    }
}
