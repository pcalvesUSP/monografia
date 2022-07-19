<?php

use Illuminate\Database\Seeder;
use App\Unitermo;

class UnitermoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Unitermo::class,50)->create();
    }
}
