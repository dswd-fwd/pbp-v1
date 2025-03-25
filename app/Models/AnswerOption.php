<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnswerOption extends Model
{
    protected $guarded = [];

    /**
     * Relationship to Answer.
     */
    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }

    /**
     * Relationship to AnswerSubOption.
     */
    // public function answerSubOptions(): HasMany
    // {
    //     return $this->hasMany(AnswerSubOption::class);
    // }

    public function answerSubOptions()
    {
        return $this->hasMany(AnswerSubOption::class, 'answer_option_id');
    }
}
