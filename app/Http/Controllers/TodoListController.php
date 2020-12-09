<?php

namespace App\Http\Controllers;

use App\TodoList;
use App\Todos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoListController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function store(Request $request, $todo)
    {

        $data = [
            'assigned_to' => Auth::id(),
            'description' => $request->description,
            'start_date'=> date("Y-m-d")
        ];
        $todos = Todos::find($todo);
        $list = $todos->lists()->create($data);
       // $todos->log()->create(['log_type' => 'list', 'list_id' => $list->id, 'log_content' => Auth::user()->name . ' Membuat tugas baru ' . $request->description]);
        return Todos::with(['lists.children' => function ($q) {
            $q->orderBy('created_at', 'desc');
        }])->find($todo);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\TodoList $todoList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->has('update')) {
            $list_id = $request->list_id;
            $list = TodoList::find($list_id);
            $list->description = $request->description;
            $list->save();
            return Todos::with(['lists' => function ($q) {
                $q->orderBy('created_at', 'desc');
            }])->find($list->todo_id);
        } else {
            $list_id = $request->list_id;
            $list = TodoList::find($list_id);
            $list->status = $list->status == 'assigned' ? 'finished' : 'assigned';
            $list->progress = $list->status == 'assigned' ? '0' : '100';
            $list->save();
            return Todos::with(['lists' => function ($q) {
                $q->orderBy('created_at', 'desc');
            }, 'lists.children'])->find($list->todo_id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\TodoList $todoList
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function destroy(TodoList $todoList, Request $request, $todo, $list)
    {
        $list = TodoList::find($list);
        $list->delete();
        return api_response(200, []);
    }
}
