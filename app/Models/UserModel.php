<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserModel extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'kopeg',        // 🔹 tambahkan ini
        'role_id',
        'profile_photo',
        'gender',       // opsional
        'divisi',       // opsional
        'alamat',       // opsional
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'role_id', 'id');
    }

    public function getAuthIdentifierName()
    {
        return 'name'; // boleh tetap ini
    }
}
