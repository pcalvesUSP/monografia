<?php

use Illuminate\Database\Seeder;
use App\OrientMonografia;

class OrientMonografiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(OrientMonografia::class,50)->create();
    }
}
