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
    
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug']  = str_slug($value);
    }
    
}
