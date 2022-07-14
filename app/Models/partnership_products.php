<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partnership_products extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'partnership_id',
        'product_id',
        'created_at',
        'updated_at',
    ];
}
