<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'status',
        'created_by'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Self Relationship
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Self Relationship
    public function creations(): HasMany
    {
        return $this->hasMany(User::class, 'created_by');
    }

    // Relationship with Class Model
    public function classes(): HasMany
    {
        return $this->hasMany(Classe::class);
    }

    // Relationship with Subject Model
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }
}
