<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngredienteRequest;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IngredienteController extends Controller
{
    /**
     * @OA\Get(
     *  path="/receitas/ingrediente/",
     *  summary="Listar objetos",
     *  operationId="listarIngredientes",
     *  tags={"receitas"},
     *  @OA\Parameter(
     *    name="page",
     *    in="query",
     *    description="Página",
     *    @OA\Schema(
     *      type="integer"
     *    )
     *  ),
     *  @OA\Parameter(
     *    name="nome",
     *    in="query",
     *    description="Ingrediente",
     *    @OA\Schema(
     *      type="string"
     *    )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Lista de objetos",
     *      @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref="#/components/schemas/Ingrediente")
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
            $filtro = $request->only('nome');
            foreach ($filtro as $nome => $valor) {
                if($valor){
                    $query->where($nome, 'LIKE', '%' . $valor . '%');
                }
            }
        };
        $data = Ingrediente::where($search)->orderBy('nome')->paginate(10);
        return response()->json([$data], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *  path="/receitas/ingrediente/",
     *  summary="Cadastrar objeto",
     *  operationId="cadastrarIngrediente",
     *  tags={"receitas"},
     *  @OA\RequestBody(
     *      required=true,
     *      description="Informar dados do objeto",
     *      @OA\JsonContent(ref="#/components/schemas/Ingrediente"),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Objeto criado com sucesso"
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PessoaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IngredienteRequest $request)
    {
        try {
            $data = Ingrediente::create($request->all());
            return response()->json([
                                    'success' => true,
                                    'status' => 200,
                                    'message' => 'Sucesso',
                                    'data' => $data
                                ]);
        } catch (\Exception $e) {
            return response()->json([
                                    'success' => false,
                                    'status' => 500,
                                    'message' => $e,
                                    'data' => $data
                                ]);
        }
    }

    /**
     * @OA\Get(
     *  path="/receitas/ingrediente/{id}/",
     *  summary="Exibir objeto",
     *  operationId="exibirIngredientes",
     *  tags={"receitas"},
     *  @OA\Parameter(
     *      description="Código do objeto",
     *      in="path",
     *      name="id",
     *      required=true,
     *      example=1,
     *      @OA\Schema(type="integer")
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Dados do objeto",
     *      @OA\JsonContent(ref="#/components/schemas/Ingrediente")
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
     * Display the specified resource.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        try {
            $ingrediente = Ingrediente::FindOrFail($id);
            return response()->json($ingrediente, 200);
        } catch(\Exception) {
            return response()->json(['message' => 'Ingrediente não encontrado'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * @OA\Put(
     *  path="/receitas/ingrediente/{id}/",
     *  summary="Atualizar objeto",
     *  operationId="atualizarIngrediente",
     *  tags={"receitas"},
     *  @OA\Parameter(
     *      description="Código do objeto",
     *      in="path",
     *      name="id",
     *      required=true,
     *      example=1,
     *      @OA\Schema(type="integer")
     *  ),
     *  @OA\RequestBody(
     *      required=true,
     *      description="Informar dados do objeto",
     *      @OA\JsonContent(ref="#/components/schemas/Ingrediente"),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Objeto atualizado com sucesso"
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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PessoaRequest  $request
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(IngredienteRequest $request, string $id)
    {
        try {
            $ingrediente = Ingrediente::FindOrFail($id);
            $ingrediente->update($request->all());
            return response()->json([
                                    'success' => true,
                                    'status' => 200,
                                    'message' => 'Sucesso',
                                    'data' => $ingrediente
                                ]);
        } catch (\Exception) {
            return response()->json(['message' => 'Ingrediente não encontrado'], 404);
        }
    }

    /**
     * @OA\Delete(
     *  path="/receitas/ingrediente/{id}/",
     *  tags={"receitas"},
     *  summary="Excluir objeto",
     *  operationId="excluirIngrediente",
     *  @OA\Parameter(
     *      description="Código do objeto",
     *      in="path",
     *      name="id",
     *      required=true,
     *      @OA\Schema(type="integer")
     *  ),
     *  @OA\Response(
     *      response=204,
     *      description="Objeto excluído com sucesso"
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
     * Remove the specified resource from storage.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        try {
            $ingrediente = Ingrediente::FindOrFail($id);
            $ingrediente->delete();
            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (\Exception) {
            return response()->json(['message' => 'Ingrediente não encontrado'], 404);
        }
    }

    /**
     * @OA\Put(
     *  path="/receitas/ingrediente/{id}/restore/",
     *  tags={"receitas"},
     *  summary="Restaurar objeto excluído",
     *  operationId="restaurarIngrediente",
     *  @OA\Parameter(
     *      description="Código do objeto",
     *      in="path",
     *      name="id",
     *      required=true,
     *      @OA\Schema(type="integer")
     *  ),
     *  @OA\Response(
     *      response=204,
     *      description="Objeto restaurado com sucesso"
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
     * Restore the specified resource from storage.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function restore(int $id)
    {
        try {
            Ingrediente::onlyTrashed()->FindOrFail($id)->restore();
            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (\Exception) {
            return response()->json(['message' => 'Ingrediente não encontrado'], 404);
        }
    }
}
