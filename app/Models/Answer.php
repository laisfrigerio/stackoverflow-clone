<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'question_id',
        'user_id',
        'body',
    ];

    public static function boot()
    {
        parent::boot();
        static::created(function ($answer) {
            $answer->question->increment('answers_count');
            $answer->question->save();
        });
        
        static::deleted(function ($answer) {
            $answer->question->decrement('answers_count');
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
    
    public function votes()
    {
        return $this->morphToMany(User::class, 'votable')
            ->withPivot('vote')
            ->withTimestamps();
    }

    /**
     * This is the best answer from a question
     * @return bool
     */
    public function isBest()
    {
        return $this->id === $this->question->best_answer_id;
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
        return $this->isBest() ? 'votes-accepted' : '';
    }
    
    /**
     * Sum total of votes from a question
     *
     * @return mixed
     */
    public function getVotesCountAttribute()
    {
        return $this->votes()->sum('vote');
    }
}
