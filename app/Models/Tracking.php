<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;

    // mass assignment fillables field
    protected $fillable = [
        'tracking_code', 'estimated_delivery'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'estimated_delivery' => 'datetime:Y-m-d',
    ];
}
