<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'statut',
        'role',
        'active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relations

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    public function resourcesResponsable()
    {
        return $this->hasMany(Resource::class, 'responsable_id');
    }
}
