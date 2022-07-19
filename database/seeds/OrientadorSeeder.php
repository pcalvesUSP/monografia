<?php

use Illuminate\Database\Seeder;
use App\Orientador;

class OrientadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Orientador::class,50)->create();
    }
}
