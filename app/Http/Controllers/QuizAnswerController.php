<?php

namespace App\Http\Controllers;

use App\Choice;
use App\QuizAnswer;
use App\QuizAnswerDetail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class QuizAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $qa = QuizAnswer::updateOrCreate(
            ['user_id'=>Auth::id(), 'challenge_id'=>$request->challenge_id],
            ['slug'=>md5(Carbon::now()->timestamp)]
        );
        $ch = Choice::where(['key'=>$request->key, 'quiz_id'=>$request->quiz_id])->first();
        $an = QuizAnswerDetail::updateOrCreate(
            ['answer_id'=>$qa->id, 'quiz_id'=>$request->quiz_id],
            ['key'=>$request->key, 'answer'=>$ch->answer, 'correct'=>$ch->correct]
        );
        return 1;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\QuizAnswer $quizAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(QuizAnswer $quizAnswer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\QuizAnswer $quizAnswer
     * @return \Illuminate\Http\Response
     */
    public function edit(QuizAnswer $quizAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\QuizAnswer $quizAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuizAnswer $quizAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\QuizAnswer $quizAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuizAnswer $quizAnswer)
    {
        //
    }
}
