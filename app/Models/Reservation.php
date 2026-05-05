<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import nécessaire
use Illuminate\Support\Str;

class Reservation extends Model
{
    use HasFactory;

    // Configuration pour les UUID
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true; 

    protected $fillable = [
        'id', // Ajouté pour permettre l'assignation manuelle si besoin
        'client_id', 
        'car_id', 
        'date_start', 
        'date_end', 
        'price', 
        'user_id'
    ];

    protected $casts = [
        'date_start' => 'date', // Cast important pour manipuler les dates de début/fin
        'date_end' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Génération automatique de l'UUID à la création
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * RELATIONS (C'est ce qui manquait pour que tout fonctionne)
     */

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}