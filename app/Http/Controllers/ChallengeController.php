<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\QuizAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChallengeController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = Challenge::with(['user'])
            ->where('challenge_status', 'publish')
            ->latest()->paginate(15);
        return view('challenge.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('challenge.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        $data = [
            'challenge_title' => $request->title,
            'challenge_content' => $request->description,
            'challenge_slug' => Str::slug($request->title) . "-" . Carbon::now()->timestamp,
        ];
        $challenge = $request->user()->challenges()->create($data);
        return redirect()->route('challenge.show', $challenge->challenge_slug)->with('success', "Tantangan berhasil dibuat");

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Challenge $challenge
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Challenge $challenge)
    {
        $challenge->increment('challenge_view');
        return view('challenge.show', compact('challenge'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Challenge $challenge
     * @return \Illuminate\Http\Response
     */
    public function edit(Challenge $challenge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Challenge $challenge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Challenge $challenge)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Challenge $challenge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Challenge $challenge)
    {
        //
    }

    public function finish($id)
    {
        $challenge = Challenge::find($id);
        $challenge->challenge_status = 'finished';
        $challenge->save();

        $answer = QuizAnswer::where(['user_id'=>Auth::id(), 'challenge_id'=>$challenge->id])->first();
        return ['code' => 200, 'url' => url('challenge/result/' . $answer->slug)];
    }

    public function result($slug)
    {
        $answer = QuizAnswer::where('slug', $slug)->first() ?? abort(404);
        $quiz_count = $answer->challenge->quizes->count();
        $answer_count = $answer->detail->count();
        $correct = 0;
        foreach ($answer->detail as $item) {
            if ($item->correct == 1) {
                $correct++;
            }
        }
        $complete_percentage = (($correct / $quiz_count) * 100);
        if ($complete_percentage > 89) {
            $label = "<span class='badge badge-success'>Baik Sekali</span>";
        } else if ($complete_percentage > 79) {
            $label = "<span class='badge badge-warning'>Baik</span>";
        } else if ($complete_percentage > 69) {
            $label = "<span class='badge badge-primary'>Cukup</span>";
        } else if ($complete_percentage <= 69) {
            $label = "<span class='badge badge-danger'>Kurang</span>";
        }
        return view('challenge.result', compact(['answer', 'quiz_count', 'answer_count', 'correct', 'complete_percentage', 'label']));
    }
}
