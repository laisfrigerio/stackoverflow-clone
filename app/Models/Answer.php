<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'question_id',
        'user_id',
        'body',
        'votes_count'
    ];

    public static function boot()
    {
        parent::boot();
        static::created(function ($answer) {
            $answer->question->increment('answers_count');
            $answer->question->save();
        });
        
        static::deleted(function ($answer) {
            $question = $answer->question;
            $question->decrement('answers_count');
            $question->save();
            
            if ($answer->id === $question->best_answer_id) {
                $question->best_answer_id = NULL;
                $question->save();
            }
        });
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mutator
     */

    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    
    public function getStatusAttribute()
    {
        return $this->id === $this->question->best_answer_id ? 'votes-accepted' : '';
    }
}
