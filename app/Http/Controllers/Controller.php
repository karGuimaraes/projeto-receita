<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\OpenApi(
 *  @OA\Info(
 *      version="1.0.0",
 *      title="API Laravel de teste",
 *      description="API Laravel de teste",
 *      @OA\Contact(
 *          name="Karine",
 *          email="karsguimaraes@gmail.com"
 *      )
 *  ),
 *  @OA\Server(
 *      url="http://localhost:{porta}/api/",
 *      description="Servidor de desenvolvimento",
 *      @OA\ServerVariable(
 *          serverVariable="porta",
 *          enum={"8000", "8001"},
 *          default="8000"
 *      )
 *  ),
 *  @OA\Components(
 *      @OA\SecurityScheme(
 *          type="http",
 *          scheme="bearer",
 *          name="JWT",
 *          securityScheme="JWT",
 *          bearerFormat="JWT",
 *          in="header"
 *      ),
 *      @OA\Response(
 *          response="UnauthorizedError",
 *          description="Token de acesso não encontrado ou inválido",
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              example={"status": "error", "message": "Token not found."}
 *          )
 *      ),
 *      @OA\Response(
 *          response="UnexpectedError",
 *          description="Erro inesperado",
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              example={"status": "error", "message": "An exception occurred while executing a query: [...]"}
 *          )
 *      ),
 *  ),
 *  security={
 *      {"JWT": {}}
 *  }
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
