<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $table = "refprovince";

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'regCode', 'id');
    }

    public function municipalities(): HasMany
    {
        return $this->hasMany(Municipality::class, 'provCode', 'provCode');
    }
}
