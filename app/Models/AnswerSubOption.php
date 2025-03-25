<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerSubOption extends Model
{
    protected $guarded = [];

    public function answerOption()
    {
        return $this->belongsTo(AnswerOption::class, 'answer_option_id');
    }
}
