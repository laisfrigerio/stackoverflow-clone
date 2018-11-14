<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $fillable = [
        'title',
        'body',
        'slug',
        'votes',
        'answers',
        'views',
        'user_id',
        'best_answer_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mutator
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
        return \Parsedown::instance()->text($this->body);
    }
    
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        if ($this->answers > 0) {

            if ($this->best_answer_id) {
                return 'answered-accepted';
            }

            return 'answered';
        }

        return 'unanswered';
    }
}
