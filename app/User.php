<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{

    use EntrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'school_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles(){
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id')
            ->withPivot('school_id');
    }

    /**
     * define relationship with the schools
     */
    public function schools(){
        return $this->belongsToMany('App\School', 'school_user', 'user_id', 'school_id');
    }
}
