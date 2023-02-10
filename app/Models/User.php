<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

use Illuminate\Auth\Authenticatable;

class User extends Model implements JWTSubject, AuthenticatableContract
{
    use Authenticatable;

    protected $table = "usuarios";

    protected $fillable = [
        'nome', 'email',
    ];

    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
