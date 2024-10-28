<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateOfBirth extends Model
{
    protected $table='date_of_births';
    protected $fillable=[
       'date_of_birth',

    ];
}
