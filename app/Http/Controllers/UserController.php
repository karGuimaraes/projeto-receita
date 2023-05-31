<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *  path="/user/login/",
     *  summary="Login",
     *  operationId="login",
     *  tags={"login"},
     *  @OA\Parameter(name="email", in="query", required=true,
     *      @OA\Schema(type="string"),
     *        description="E-mail",
     *  ),
     *  @OA\Parameter(name="password", in="query", required=true,
     *      @OA\Schema(type="string"),
     *        description="Senha",
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Token gerado com sucesso"
     *  ),
     *  @OA\Response(
     *      response=500,
     *      ref="#/components/responses/UnexpectedError"
     *  )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        if(!Auth::attempt(['email' => $request->query('email'), 'password' => $request->query('password')]))
        {
            throw new HttpResponseException(response()->json(['Usuário ou senha inválido'], 401));
        }

        $time = 60; // prazo para expiração do token em minutos
        JWTAuth::factory()->setTTL($time);
        $token = JWTAuth::fromUser(Auth::user());
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }

    /**
     * @OA\Post(
     *  path="/user/sign/",
     *  summary="Cadastrar usuário",
     *  operationId="cadastrarUsuario",
     *  tags={"login"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Informar dados do objeto",
     *      @OA\JsonContent(ref="#/components/schemas/User"),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Objeto criado com sucesso"
     *  ),
     *  @OA\Response(
     *      response=500,
     *      ref="#/components/responses/UnexpectedError"
     *  )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ];
        $user = User::create($data);
        return response()->json([$user], Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Get(
     *  path="/user/logout/",
     *  summary="Deslogar o usuário",
     *  operationId="logout",
     *  tags={"login"},
     *  @OA\Response(
     *      response=204,
     *      description="Logout efetuado com sucesso"
     *  ),
     *  @OA\Response(
     *      response=401,
     *      ref="#/components/responses/UnauthorizedError"
     *  ),
     *  @OA\Response(
     *      response=500,
     *      ref="#/components/responses/UnexpectedError"
     *  )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Get(
     *  path="/user/refresh/",
     *  summary="atualizar token do usuário",
     *  operationId="refresh",
     *  tags={"login"},
     *  @OA\Response(
     *      response=200,
     *      description="Token gerado com sucesso"
     *  ),
     *  @OA\Response(
     *      response=401,
     *      ref="#/components/responses/UnauthorizedError"
     *  ),
     *  @OA\Response(
     *      response=500,
     *      ref="#/components/responses/UnexpectedError"
     *  )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = JWTAuth::parseToken()->refresh();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }

}
