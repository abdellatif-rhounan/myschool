<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classe extends Model
{
    use SoftDeletes;

    // Relationship with User Model
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship with Subject Model
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }

    // Relationship with User Model
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    // Relationship with User Model
    public function students(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
