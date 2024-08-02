<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    use SoftDeletes;

    // Relationship with User Model
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship with Classe Model
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classe::class)
            ->withPivot('status', 'created_by')
            ->withTimestamps();
    }
}
