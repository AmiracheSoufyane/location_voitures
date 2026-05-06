<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasUuids;
    protected $fillable = [
    'car_id',
    'type',
    'maintenance_date',
    'cost',
    'mileage'
    ];
    public function Car(){
        return $this->belongsTo(Car::class);
    }
}
