<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Tag(name="receitas", description="Receitas"),
 * @OA\Schema(
 *  title="Ingredientes",
 *  required={"nome"},
 *  @OA\Property(property="id", type="integer", readOnly=true, example=1),
 *  @OA\Property(property="nome", type="string", example="ovo"),
 * )
 */
class Ingrediente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ingredientes';
    protected $primaryKey = 'id';

    protected $fillable = ['nome'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
