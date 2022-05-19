<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class partnership_user extends Model
{
    use HasFactory;

    protected $fillable = [
        'partnership_id',
        'user_id',
    ];
}
