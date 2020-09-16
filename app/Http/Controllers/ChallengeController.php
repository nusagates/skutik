<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\QuizAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use GDText\Box;
use GDText\Color;


class ChallengeController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified', ['except' => ['index', 'show', 'result', 'result_image', 'finish']]);
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

    public function finish(Request $request)
    {

        $answer = QuizAnswer::find($request->answer_id);
        $answer->status = 'finished';
        $answer->save();
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
    public function result_image($slug){
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
            $label = "Baik Sekali";
        } else if ($complete_percentage > 79) {
            $label = "Baik";
        } else if ($complete_percentage > 69) {
            $label = "Cukup";
        } else if ($complete_percentage <= 69) {
            $label = "Kurang";
        }
        header('Content-type: image/png');
        $im = imagecreatefrompng(public_path('images/bg_result.png'));
        $greeting = 'Challenge Result';

        $red = new Color(255, 0, 0);
        $orange = new Color(255, 163, 0);
        $green = new Color(23, 86, 65);
        $blue = new Color(82, 133, 255);
        $black = new Color(0, 0, 0);
        $pink = new Color(255, 75, 140);

        $font = public_path('/fonts/sb.otf');
        $box = new Box($im);
        $box->setFontFace($font);
        $box->setFontColor($pink);
        $box->setTextAlign('center', 'top');
        $box->setBox(15, 27, 640, 60);
        $box->setFontSize(16);
        $box->draw(strtoupper($greeting));

        $box2 = new Box($im);
        $box2->setFontFace($font);
        $box2->setFontColor($pink);
        $box2->setTextAlign('center', 'top');
        $box2->setBox(15, 67, 640, 60);
        $box2->setFontSize(16);
        $box2->draw(strtoupper($answer->challenge->challenge_title));

        //bagian nama
        $box3 = new Box($im);
        $box3->setFontFace($font);
        $box3->setFontColor($black);
        $box3->setTextAlign('left', 'top');
        $box3->setBox(15, 110, 640, 60);
        $box3->setFontSize(16);
        $box3->draw("Name");

        $box3b = new Box($im);
        $box3b->setFontFace($font);
        $box3b->setFontColor($black);
        $box3b->setTextAlign('left', 'top');
        $box3b->setBox(100, 110, 640, 60);
        $box3b->setFontSize(16);
        $box3b->draw(': '.strtoupper($answer->user->name));

        //bagian skor
        $box4 = new Box($im);
        $box4->setFontFace($font);
        $box4->setFontColor($black);
        $box4->setTextAlign('left', 'top');
        $box4->setBox(15, 150, 640, 60);
        $box4->setFontSize(16);
        $box4->draw("Score");

        $box3b = new Box($im);
        $box3b->setFontFace($font);
        $box3b->setFontColor($black);
        $box3b->setTextAlign('left', 'top');
        $box3b->setBox(100, 150, 640, 60);
        $box3b->setFontSize(16);
        $box3b->draw(': '.strtoupper($complete_percentage));

        //ucapan selamat
        $box5 = new Box($im);
        $box5->setFontFace($font);
        $box5->setFontColor($black);
        $box5->setTextAlign('center', 'top');
        $box5->setBox(15, 190, 640, 60);
        $box5->setFontSize(16);
        $box5->draw("Congrats! You have successfully completed the challenge with the title");

        //signature
        $box5 = new Box($im);
        $box5->setFontFace($font);
        $box5->setFontColor($black);
        $box5->setTextAlign('center', 'top');
        $box5->setBox(330, 280, 300, 60);
        $box5->setFontSize(14);
        $box5->draw("challenger");
        $box5 = new Box($im);
        $box5->setFontFace($font);
        $box5->setFontColor($black);
        $box5->setTextAlign('center', 'top');
        $box5->setBox(330, 310, 300, 60);
        $box5->setFontSize(14);
        $box5->draw($answer->challenge->author);

        //predikat
        $box5 = new Box($im);
        $box5->setFontFace($font);
        if ($complete_percentage > 89) {
            $box5->setFontColor($green);
        } else if ($complete_percentage > 79) {
            $box5->setFontColor($blue);
        } else if ($complete_percentage > 69) {
            $box5->setFontColor($orange);
        } else if ($complete_percentage <= 69) {
            $box5->setFontColor($red);
        }
        $box5->setTextAlign('center', 'top');
        $box5->setBox(15, 225, 640, 60);
        $box5->setFontSize(25);
        $box5->draw(strtoupper(strip_tags($label)));

        imagepng($im);
    }
}
