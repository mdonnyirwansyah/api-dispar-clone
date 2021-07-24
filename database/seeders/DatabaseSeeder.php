<?php

namespace Database\Seeders;

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
        $this->call([
            RoleSeeder::class,
            NewsCategorySeeder::class,
            NewsTagSeeder::class,
            NewsPostSeeder::class,
            NewsPostNewsTagSeeder::class,
            RoleUserSeeder::class
        ]);
    }
}
