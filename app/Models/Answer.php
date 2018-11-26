<?php

namespace App\Models;

use App\Traits\VotableTrait;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use VotableTrait;

    protected $fillable = [
        'question_id',
        'user_id',
        'body',
        'votes_counter',
    ];

    protected  $appends = [
        'created_date', 'body_html'
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
        return clean(\Parsedown::instance()->text($this->body));
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
