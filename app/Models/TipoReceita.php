<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Tag(name="receitas", description="Receitas"),
 * @OA\Schema(
 *  title="Tipo Receitas",
 *  required={"descricao"},
 *  @OA\Property(property="id", type="integer", readOnly=true, example=1),
 *  @OA\Property(property="descricao", type="string", example="Lanche"),
 * )
 */
class TipoReceita extends Model
{
    use HasFactory;

    protected $table = 'est_tipo_receitas';
    protected $primaryKey = 'id';

    protected $fillable = ['descricao'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
