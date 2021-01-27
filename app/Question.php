<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{

    protected $guarded = [];
    /*
     * MUTATORS- These are special funcrions which have setxxxAttribute($value)
     */

    public function setTitleAttribute($title)
    {
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = Str::slug($title);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }

    public function favourites()
    {
        return $this->belongsToMany(User::class)->withTimeStamps();
    }

    public function votes()
    {
        return $this->morphToMany(User::class, 'vote')->withTimestamps();
    }

    public function getUrlAttribute()
    {
        return "/questions/{$this->slug}";
    }

    public function getAnswersStyleAttribute()
    {
        if($this->answers_count > 0) {
            if($this->best_answer_id) {
                return "has-best-answer";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getFavouritesCountAttribute()
    {
        return $this->favourites->count();
    }

    public function getIsFavouriteAttribute()
    {
        return $this->favourites()->where(['user_id'=>auth()->id()])->count() > 0;
    }

    /*
    * HELPER FUNCTIONS
    */
    public function markBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function vote(int $vote)
    {
        $this->votes()->attach(auth()->id(), ['vote'=>$vote]);
        if($vote > 0)
        {
            $this->increment('votes_count');
        }
        else
        {
            $this->decrement('votes_count');
        }
    }

    public function updateVote(int $vote)
    {
        $this->votes()->updateExistingPivot(auth()->id(), ['vote'=> $vote]);
        if($vote > 0)
        {
            $this->increment('votes_count');
            $this->increment('votes_count');
        }
        else
        {
            $this->decrement('votes_count');
            $this->decrement('votes_count');
        }
    }

}
