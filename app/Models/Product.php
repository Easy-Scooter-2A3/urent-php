<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false; // TODO: remove this line

    protected $fillable = [
        'name',
        'price',
        'description',
        'stock',
        'available',
    ];
}
