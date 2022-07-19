<?php

use Illuminate\Database\Seeder;
use App\Monografia;

class MonografiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Monografia::class,50)->create();
    }
}
