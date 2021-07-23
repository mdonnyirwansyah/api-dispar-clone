<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->insert(
            [
                'role_id' => Role::select('id')->orderByRaw("RAND()")->first()->id,
                'user_id' => User::select('id')->orderByRaw("RAND()")->first()->id,
            ]
        );
    }
}
