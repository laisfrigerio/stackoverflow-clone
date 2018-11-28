<?php

namespace App\Models;

use App\Traits\VotableTrait;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use VotableTrait;

    public $fillable = [
        'title',
        'body',
        'slug',
        'answers',
        'views',
        'user_id',
        'best_answer_id',
        'votes_counter',
    ];

    protected $appends = [
        'created_date', 'is_favorited', 'favorites_count'
    ];

    /**
     * Relations
     */

    public function answers()
    {
        return $this->hasMany(Answer::class)->orderBy('votes_counter', 'DESC');
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites') // 'question_id', 'user_id'
            ->withTimestamps();
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isFavorited()
    {
        return $this->favorites()
                ->where('user_id', auth()->id())
                ->count() > 0;
    }

    /**
     * Mutator
     */

    /**
     * @param $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug']  = str_slug($value);
    }
    
    public function getUrlAttribute()
    {
        return route('questions.show', $this->slug);
    }

    public function getBodyHtmlAttribute()
    {
        return clean(\Parsedown::instance()->text($this->body));
    }
    
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getStatusAttribute()
    {
        if ($this->answers_count > 0) {

            if ($this->best_answer_id) {
                return 'answered-accepted';
            }

            return 'answered';
        }

        return 'unanswered';
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
    
    /**
     * Sum total of answers from a question
     *
     * @return mixed
     */
    public function getAnswersCountAttribute()
    {
        return $this->answers()->count();
    }

}
