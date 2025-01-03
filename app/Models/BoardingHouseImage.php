<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardingHouseImage extends Model
{
    protected $fillable = [
        'boarding_house_id',
        'image'
    ];
}
