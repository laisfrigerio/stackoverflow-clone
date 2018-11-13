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
        'author_id',
        'best_answer_id',
    ];
    
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug']  = str_slug($value);
    }
    
}
