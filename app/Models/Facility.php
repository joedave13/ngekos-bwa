<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = [
        'boarding_house_id',
        'name',
        'description',
        'image'
    ];
}
