<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\ChallengeQuiz;
use Illuminate\Http\Request;

class ChallengeQuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Challenge $challenge)
    {

        $quiz = ChallengeQuiz::with('choices')->where('challenge_id', $challenge->id)->paginate(1);
        //return $quiz;
        return view('challenge.quiz', compact(['quiz', 'challenge']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Challenge $challenge)
    {
        return 1;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Challenge $challenge, Request $request)
    {
        $quiz = $challenge->quizes()->create($request->only('question'));
        $answers = array_filter($request->answer);
        foreach ($answers as $k => $item) {
            if ($request->correct == $k) {
                $quiz->choices()->create(['key' => $k, 'answer' => $item, 'correct' => 1]);
            } else {
                $quiz->choices()->create(['key' => $k, 'answer' => $item, 'correct' => 0]);
            }
        }
        $challenge = Challenge::with('quizes.choices')->find($challenge->id);
        return response()->json(['code' => 200, 'quiz' => $challenge->quizes]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ChallengeQuiz $challengeQuiz
     * @return \Illuminate\Http\Response
     */
    public function show(ChallengeQuiz $challengeQuiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ChallengeQuiz $challengeQuiz
     * @return \Illuminate\Http\Response
     */
    public function edit(ChallengeQuiz $challengeQuiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ChallengeQuiz $challengeQuiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChallengeQuiz $challengeQuiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ChallengeQuiz $challengeQuiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChallengeQuiz $challengeQuiz)
    {
        //
    }
}
