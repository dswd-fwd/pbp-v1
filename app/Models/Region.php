<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    protected $table = "refregion";

    public function provinces(): HasMany
    {
        return $this->hasMany(Province::class, 'regCode', 'regCode');
    }
}
