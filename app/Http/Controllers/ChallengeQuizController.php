<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\ChallengeQuiz;
use App\Choice;
use App\QuizAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $answer_count = QuizAnswer::where(['user_id' => Auth::id(), 'challenge_id' => $challenge->id])->get()->count();

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Challenge $challenge, $quiz)
    {
        $challengeQuiz = ChallengeQuiz::find($quiz)->update(['question' => $request->question]);
        $choices = $request->choices;
        foreach ($choices as $item) {
            $id = $item['id'];
            $data = [
                'answer' => $item['answer'],
                'correct' => $request->selected == $item['key'] ? 1 : 0
            ];
            Choice::find($id)->update($data);
        }
        $challenge = Challenge::with('quizes.choices')->find($challenge->id);
        return response()->json(['code' => 200, 'quiz' => $challenge->quizes]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ChallengeQuiz $challengeQuiz
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Challenge $challenge, ChallengeQuiz $challengeQuiz, $quiz)
    {
        $challengeQuiz = ChallengeQuiz::find($quiz);
        $challengeQuiz->delete();
        $challenge = Challenge::with('quizes.choices')->find($challenge->id);
        return response()->json(['code' => 200, 'quiz' => $challenge->quizes]);
    }
}
