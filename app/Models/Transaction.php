<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'code',
        'name',
        'email',
        'phone',
        'boarding_house_id',
        'room_id',
        'start_date',
        'end_date',
        'duration_in_month',
        'price',
        'sub_total',
        'vat',
        'insurance_amount',
        'grand_total_amount',
        'payment_method',
        'payment_status',
        'midtrans_snap_token'
    ];
}
