<?php

namespace App\Models\Global_Info;

use Illuminate\Database\Eloquent\Model;

class Gendef extends Model
{
    protected $table = 'gendef';

    protected $fillable = [
        'name', 'tb','status',
    ];
}
