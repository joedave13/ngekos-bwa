<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'boarding_house_id',
        'name',
        'testimonial',
        'rating'
    ];
}
