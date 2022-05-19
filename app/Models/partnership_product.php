<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partnership_product extends Model
{
    use HasFactory;

    protected $fillable = [
        'partnership_id',
        'product_id',
    ];
}
