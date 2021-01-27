<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Answer;

class VotesController extends Controller
{
    public function upVoteQuestion(Question $question)
    {
        return $this->voteQuestion($question, 1);
    }
    public function downVoteQuestion(Question $question)
    {
        return $this->voteQuestion($question, -1);
    }
    private function voteQuestion(Question $question, int $vote)
    {
        if(auth()->user()->hasVoteForQuestion($question))
        {
            $question->updateVote($vote);
        }
        else
        {
            $question->vote($vote);
        }
        return redirect()->back();
    }
    public function upVoteAnswer(Answer $answer)
    {
        return $this->voteAnswer($answer, 1);
    }
    public function downVoteAnswer(Answer $answer)
    {
        return $this->voteAnswer($answer, -1);
    }
    private function voteAnswer(Answer $answer, int $vote)
    {
        if(auth()->user()->hasVoteForAnswer($answer))
        {
            $answer->updateVote($vote);
        }
        else
        {
            $answer->vote($vote);
        }
        return redirect()->back();
    }
}
