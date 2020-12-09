<?php

namespace App\Http\Controllers;

use App\TodoList;
use App\TodoLog;
use App\TodoMember;
use App\Todos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = Auth::user()->todos;
        return view('todo.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:50']
        ]);
        $todo_data = [
            'slug' => strrev(Carbon::now()->timestamp),
            'title' => $request->title,
            'description' => $request->description
        ];
        $todo = Todos::create($todo_data);
        TodoLog::create(['todo_id' => $todo->id, 'log_type' => 'todo', 'log_content' => Auth::user()->name . ' Membuat proyek ' . $request->title]);
        TodoMember::firstOrCreate(['todo_id' => $todo->id, 'user_id' => Auth::id()]);
        return redirect(route('todo.show', $todo->slug))->with('success', 'Proyek berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Todos $todos
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Todos $todos, Request $request)
    {
        if ($request->ajax()) {
            $list = TodoList::with('todo', 'children')->where('todo_id', $todos->id)->paginate(30);
            return api_response(200, ['todo' => $todos, 'list' => $list], "Sukses");
        }
        return view('todo.list', ['slug' => $todos->slug]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Todos $todos
     * @return \Illuminate\Http\Response
     */
    public function edit(Todos $todos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Todos $todos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todos $todos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Todos $todos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todos $todos)
    {
        //
    }
}
