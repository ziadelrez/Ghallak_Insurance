<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Userstype extends Authenticatable
{
    //
    use Notifiable;

    protected $table = 'role';

    protected $fillable = [
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function users(){
        return $this -> hasMany(User::class,'role_id');
    }
}
