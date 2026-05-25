<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username'   => 'admin',
            'email'      => 'admin@gmail.com',
            'password'   => Hash::make('admin123'),
            'no_telpon'  => '085656488508',
            'role'       => 'admin',
        ]);

        User::create([
            'username'   => 'manajer',
            'email'      => 'manajer@gmail.com',
            'password'   => Hash::make('manajer123'),
            'no_telpon'  => '0895614710240',
            'role'       => 'manajer',
        ]);
    }
}
