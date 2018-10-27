<?php
namespace Backend\Models;
use Illuminate\Support\Facades\DB;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Lang, Cache;

class AuthUser extends Authenticatable
{
    protected $table = 'users';
    protected $fillable = [
        'name', 'email', 'password',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
}
