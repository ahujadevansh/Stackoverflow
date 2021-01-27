<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded =[];
    /*
     * RELATIOSHIP METHODS
     */

    public static function boot() {
        parent::boot();

        static::created(function($answer){
            $answer->question->increment('answers_count');
        });
    }

    public function question() {
        return $this->belongsTo(Question::class);
    }

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function votes()
    {
        return $this->morphToMany(User::class, 'vote')->withTimestamps();
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getBestAnswerStatusAttribute() {
        if($this->id === $this->question->best_answer_id) {
            return "text-success";
        }
        return "text-dark";
    }

    public function getIsBestAttribute() {
        return $this->id === $this->question->best_answer_id;
    }

    /*
    * HELPER FUNCTIONS
    */

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

