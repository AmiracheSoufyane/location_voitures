<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasUuids;
    protected $fillable = [
    'brand',
    'model',
    'year',
    'registration',
    'fuel_type',
    'mileage',
    'status',
    'price_per_day',
    'image',
    ];
}
