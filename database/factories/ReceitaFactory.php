<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Receita>
 */
class ReceitaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vReceitas = ['Pão com ovo', 'Carne com batata frita', 'Frutas com leite em pó', 'Tapioca com presento e queijo', 'Carne de panela'];
        $countTipo = DB::table('est_tipo_receitas')->count();
        return [
            'nome' => $vReceitas[array_rand($vReceitas)],
            'descricao' => fake('pt_BR')->text(),
            'est_tipo_receitas_id' => rand(1, $countTipo)
        ];
    }
}
