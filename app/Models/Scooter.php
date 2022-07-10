<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

enum ScooterStatus: int {
    case SCOOTER_STATUS_UNSPECIFIED = 0;
    case SCOOTER_STATUS_AVAILABLE = 1;
    case SCOOTER_STATUS_IN_MAINTENANCE = 2;
    case SCOOTER_STATUS_IN_USE = 3;
    case SCOOTER_STATUS_IN_REPAIR = 4;
    case SCOOTER_STATUS_LOCKED = 5;

    public static function getStatus(int $status) {
        return match(self::from($status)) {
            static::SCOOTER_STATUS_UNSPECIFIED => 'Unspecified',
            static::SCOOTER_STATUS_AVAILABLE => 'Available',
            static::SCOOTER_STATUS_IN_MAINTENANCE => 'In maintenance',
            static::SCOOTER_STATUS_IN_USE => 'In use',
            static::SCOOTER_STATUS_IN_REPAIR => 'In repair',
            static::SCOOTER_STATUS_LOCKED => 'Locked',
            default => 'Unknown'
        };
    }
}

class Scooter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'model',
        'status',
        'latitude',
        'longitude',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'available',
    ];
}
