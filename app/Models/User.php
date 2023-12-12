<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'image',
        'rol',
        'status',
        'provider',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin()
    {
        return $this->rol === 'Administrador';
    }

    public function isEmployee()
    {
        return $this->rol === 'Empleado';
    }

    public function isClient()
    {
        return $this->rol === 'Cliente';
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
}
