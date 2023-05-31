<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingediente>
 */
class IngredienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vAlimentos = ['farinha', 'ovo', 'leite', 'pão', 'carne'];
        return [
            'nome' => $vAlimentos[array_rand($vAlimentos)]
        ];
    }
}
