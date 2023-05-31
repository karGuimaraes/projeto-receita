<?php

namespace App\Http\Controllers;

use App\Models\TipoReceita;
use Illuminate\Http\Request;

class TipoReceitaController extends Controller
{
    /**
     * @OA\Get(
     *  path="/receitas/tipo-receitas/",
     *  summary="Listar objetos",
     *  operationId="listarTipoReceitas",
     *  tags={"receitas"},
     *  @OA\Parameter(
     *    name="descricao",
     *    in="query",
     *    description="Tipo de receita",
     *    @OA\Schema(
     *      type="string"
     *    )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Lista de objetos",
     *      @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref="#/components/schemas/TipoReceita")
     *      )
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
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = function ($query) use($request) {
            $filtro = $request->only('descricao');
            foreach ($filtro as $nome => $valor) {
                if($valor){
                    $query->where($nome, 'LIKE', '%' . $valor . '%');
                }
            }
        };
        $data = TipoReceita::where($search)->orderBy('descricao')->paginate(10);
        return response()->json([$data], 200);
    }
}
