<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'description', 'cpu', 'ram', 'capacite', 'os', 
        'etat', 'emplacement', 'categorie_id', 'responsable_id'
    ];

    public function category()
    {
        return $this->belongsTo(ResourceCategory::class, 'categorie_id');
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function comments()
    {
    return $this->hasMany(Comment::class);
    }
}
