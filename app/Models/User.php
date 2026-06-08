<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'password',
        'no_telpon',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function login(): void
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $auth->attempt([
            'username' => $this->username,
            'password' => $this->password,
        ]);
    }

    public function logout(): void
    {
        /** @var \Illuminate\Auth\SessionGuard $auth */
        $auth = auth();
        $auth->logout();
    }

    public function tampilData(): array
    {
        return [];
    }

    public function updateProfile(array $data): void
    {
        $this->update($data);
    }
}
