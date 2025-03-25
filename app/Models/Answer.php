<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Answer extends Model
{
    protected $guarded = [];

    /**
     * Get all answer options related to this answer.
     */
    public function answerOptions(): HasMany
    {
        return $this->hasMany(AnswerOption::class);
    }

    /**
     * Get all sub-options through answer options.
     */
    public function answerSubOptions(): HasManyThrough
    {
        return $this->hasManyThrough(AnswerSubOption::class, AnswerOption::class);
    }
}
