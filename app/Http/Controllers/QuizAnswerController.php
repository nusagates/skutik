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
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function store(Request $request)
    {

        $qa = QuizAnswer::updateOrCreate(
            ['user_id' => Auth::id(), 'challenge_id' => $request->challenge_id],
            ['slug' => md5(Carbon::now()->timestamp)]
        );
        $ch = Choice::where(['key' => $request->key, 'quiz_id' => $request->quiz_id])->first();
        $an = QuizAnswerDetail::updateOrCreate(
            ['answer_id' => $qa->id, 'quiz_id' => $request->quiz_id],
            ['key' => $request->key, 'answer' => $ch->answer, 'correct' => $ch->correct]
        );
        return ['code' => 200, 'answer' => $qa];
    }

}
