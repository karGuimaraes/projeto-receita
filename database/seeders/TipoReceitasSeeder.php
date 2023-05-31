<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoReceitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('est_tipo_receitas')->insertOrIgnore([
            ['descricao' => 'Lanche'],
            ['descricao' => 'Sobremesa'],
            ['descricao' => 'Refeição'],
        ]);
    }
}
