<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasUuids;
    protected $fillable = [
        'note',
        'car_id'
    ];
    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
}
