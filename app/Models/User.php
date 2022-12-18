<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Cache;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){

        return $this->belongsTo(Role::class);

    }

    public function isOnline(){

        return Cache::has('user-is-online-' .$this->id);
    }


    public function  isSuperAdmin(){
         
        if($this->role->name == "SuperAdmin" ){

            return true;
        }

        return false; 
    }


    public function  isAdmin(){
         
        if($this->role->name == "Admin" ){

            return true;
        }

        return false; 
    }

    public function  isUser(){
         
        if($this->role->name == "User" ){

            return true;
        }

        return false; 
    }
}
