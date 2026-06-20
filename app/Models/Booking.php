<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'reference',
        'flight_identifier',
        'flight_snapshot',
        'passengers',
    ];

    protected $casts = [
        'flight_snapshot' => 'array',
        'passengers' => 'array',
    ];
}