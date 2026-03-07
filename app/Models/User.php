<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens; // ← ADD THIS

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

// In App\Models\User.php
public function address()
{
    return $this->hasOne(\App\Models\CustomerAddress::class);
}
}
