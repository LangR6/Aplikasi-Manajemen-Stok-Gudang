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
            'username'   => 'admin1',
            'email'      => 'Gilang@gmail.com',
            'password'   => Hash::make('admin123'),
            'no_telpon'  => '085656488508',
            'role'       => 'admin',
        ]);

        User::create([
            'username'   => 'admin2',
            'email'      => 'Ayumi@gmail.com',
            'password'   => Hash::make('admin123'),
            'no_telpon'  => '085767755877',
            'role'       => 'admin',
        ]);

        User::create([
            'username'   => 'manajer',
            'email'      => 'Tiara@gmail.com',
            'password'   => Hash::make('manajer123'),
            'no_telpon'  => '0895614710240',
            'role'       => 'manajer',
        ]);
    }
}
