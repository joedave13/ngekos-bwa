<?php

namespace App\Models;

use App\Enums\TransactionPaymentMethod;
use App\Enums\TransactionPaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'boarding_house_price',
        'room_price',
        'sub_total',
        'vat',
        'insurance_amount',
        'grand_total_amount',
        'payment_method',
        'payment_status',
        'midtrans_snap_token'
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'duration_in_month' => 'integer',
            'boarding_house_price' => 'integer',
            'room_price' => 'integer',
            'sub_total' => 'integer',
            'vat' => 'integer',
            'insurance_amount' => 'integer',
            'grand_total_amount' => 'integer',
            'payment_method' => TransactionPaymentMethod::class,
            'payment_status' => TransactionPaymentStatus::class,
        ];
    }

    public function boardingHouse(): BelongsTo
    {
        return $this->belongsTo(BoardingHouse::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
