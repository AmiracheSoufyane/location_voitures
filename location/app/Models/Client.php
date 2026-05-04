<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasUuids;
    protected $fillable = [
        'name',
        'license_number',
        'national_id',
        'address',
        'city',
        'country',
        'notes',
        'license_image_front',
        'license_image_back',
        'national_id_image_front',
        'national_id_image_back',
    ];
}
