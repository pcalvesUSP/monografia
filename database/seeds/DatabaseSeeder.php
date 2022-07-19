<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(UnitermoSeeder::class);
        $this->call(MonografiaSeeder::class);
        $this->call(AlunoSeeder::class);
        $this->call(OrientadorSeeder::class);
        //$this->call(OrientMonografiaSeeder::class);
    }
}
