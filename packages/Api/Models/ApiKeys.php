<?php
namespace Api\Models;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Cache;

class ApiKeys extends Authenticatable
{
    protected $table = 'api_keys';
    protected $fillable = [
        'username', 'email', 'token'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
}
