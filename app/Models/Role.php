<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ADMIN_ROLE = 'admin';
    const USER_ROLE = 'user';

    public static $roles = [
        self::ADMIN_ROLE,
        self::USER_ROLE
    ];

    protected $fillable = [
        'role'
    ];
}
