<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'url', 'avatar'
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps(); // 'user_id', 'question_id'
    }
    
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    
    public function questionsVote()
    {
        return $this->morphedByMany(Question::class, 'votable')->withTimestamps();
    }
    
    public function answersVote()
    {
        return $this->morphedByMany(Answer::class, 'votable')->withTimestamps();
    }

    /**
     * Mutator
     */

    public function getAvatarAttribute()
    {
        $email = $this->email;
        $size = 32;
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size . "&d=identicon";
    }

    public function getUrlAttribute()
    {
        // return route("questions.show", $this->id);
        return '#';
    }
}
