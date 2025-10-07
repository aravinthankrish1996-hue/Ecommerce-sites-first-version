<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;
use URL;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasApiTokens,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
            'email',
            'password',
            'phone',
            'image',
            'address',
            'x_link',
            'fb_link' ,
            'insta_link'
       
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        "email_verified_at"
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected  $casts=[
    
            'email_verified_at' => 'datetime',
              'password' => 'hashed', 
  
        ];
    public function roles()
    {
        return $this->belongsToMany(Role::class,'user_roles');
    }
    public function hasRole(...$roles)
    {
        foreach($roles as $role){
            if($this->roles->Contains('slug',$role)){
                return true;
            }
        }
        return false;
    }
}
