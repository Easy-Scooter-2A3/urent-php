<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waypoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_latitude',
        'start_longitude',
        'end_latitude',
        'end_longitude',
        'start_timestamp',
        'end_timestamp',
        'waypoints',
        'distance_meters'
    ];
}
