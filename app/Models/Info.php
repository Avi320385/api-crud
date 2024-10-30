<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $table='infos';
    protected $fillable=[
       'name',
       'email',
       'password',
       'phone',
       'adress',
       'date_of_birth',
       'image'
    ];
}
