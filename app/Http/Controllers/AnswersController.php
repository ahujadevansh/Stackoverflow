<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Http\Requests\answers\CreateAnswerRequest;
use App\Http\Requests\answers\UpdateAnswerRequest;
use Illuminate\Http\Request;
use \App\Question;
use App\Notifications\NewReplyAdded;

class AnswersController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAnswerRequest $request, Question $question)
    {
        $question->answers()->create([
            'body'=>$request->body,
            'user_id'=>auth()->id()
        ]);
        $question->owner->notify(new NewReplyAdded($question));
        session()->flash('success', 'Your answer submitted succesfully!');
        return redirect($question->url);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question, Answer $answer)
    {
        return view('answers.edit', compact(['question','answer']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnswerRequest $request, Question $question, Answer $answer)
    {
        $answer->update([
            'body'=> $request->body,
        ]);
        session()->flash('success', 'Your answer Updated succesfully!');
        return redirect($question->url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);
        $answer->delete();
        $answer->question->decrement('answers_count');
        session()->flash('success', 'Answer Deleted succesfully!');
        return redirect($question->url);
    }

    public function bestAnswer(Request $request, Answer $answer)
    {
        $this->authorize('markAsBest', $answer);
        $answer->question->markBestAnswer($answer);
        return redirect()->back();
    }
}
