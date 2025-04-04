<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipality extends Model
{
    protected $table = "refcitymun";

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'provCode', 'id');
    }

    public function barangay(): HasMany {
        return $this->hasMany(Barangay::class, 'citymunCode', 'citymunCode');
    }
}
