<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function getHasOtherOptionsAttribute()
    {
        return $this->options()->where('has_other', 1)->exists() ? 1 : 0;
    }
}
