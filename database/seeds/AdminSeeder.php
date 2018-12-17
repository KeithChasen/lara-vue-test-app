<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'email' => 'admin@mail.com',
            'name' => 'admin',
            'password' => bcrypt('admin'),
            'role_id' => Role::where('role', Role::ADMIN_ROLE)->first()->id
        ]);
    }
}
