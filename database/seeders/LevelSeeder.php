<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Level::insert([
            [
                'id' => 1,
                'name' => 'Admin',
                'primary' => 1,
            ],
            [
                'id' => 2,
                'name' => 'User',
                'primary' => 0,
            ]
        ]);
    }
}
