<?php

namespace App\Models\Def_Info;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branch';

    protected $fillable = [
        'name', 'location', 'landline', 'mobile','created_by', 'created_at','updated_by','updated_at',
    ];

//    public function users()
//    {
//        return $this->hasMany(User::class);
//    }
}
