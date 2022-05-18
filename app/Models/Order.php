<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'delivery_place',
        'delivery_date',
        'transporter',
        'transporter_tracking_number',
        'user_id',
        'total_price',
        'payment_method',
        'total_tax',
        'total_discount',
        'recu'
    ];
}
