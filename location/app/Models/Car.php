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
    'rest',
    'en_panne',
    'maintenance_needed'
    ];

    public function notifications()
{
    return $this->hasMany(Notification::class)->orderBy('created_at', 'asc');
}
    public function maintenances(){
        return $this->hasMany(Maintenance::class,'car_id');
    }
    public function reservations(){
        return $this->hasMany(Reservation::class,'car_id');
    }
}
