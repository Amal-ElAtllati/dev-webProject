<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'resource_id',
        'reservation_id',
        'type',
        'priorite',
        'titre',
        'description',
        'fichiers',
        'statut',
        'reponse_admin',
        'date_signalement',
        'date_resolution'
    ];

    protected $casts = [
        'fichiers' => 'array',
        'date_signalement' => 'datetime',
        'date_resolution' => 'datetime'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}