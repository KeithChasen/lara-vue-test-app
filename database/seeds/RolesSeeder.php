<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    public function run()
    {
        foreach (Role::$roles as $role) {
            Role::create(['role' => $role]);
        }
    }
}
