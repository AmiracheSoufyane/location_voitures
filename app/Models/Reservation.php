<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasUuids;
    protected $fillable = [
        "user_id",
        "client_id",
        "car_id",
        "date_start",
        "date_end",
        "price",
    ];
    public function car(){
        return $this->belongsTo(Car::class,'car_id');
    }
    public function client(){
        return $this->belongsTo(Client::class,'client_id');
    }
}
