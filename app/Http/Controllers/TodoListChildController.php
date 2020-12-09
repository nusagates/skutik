<?php

namespace App\Http\Controllers;

use App\TodoList;
use App\TodoListChild;
use Illuminate\Http\Request;

class TodoListChildController extends Controller
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
        $list = TodoList::find($request->list_id);
        if ($list) {
            $list->children()->create(['description' => $request->text]);
        }
        return api_response(200, $list);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\TodoListChild $todoListChild
     * @return \Illuminate\Http\Response
     */
    public function show(TodoListChild $todoListChild)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\TodoListChild $todoListChild
     * @return \Illuminate\Http\Response
     */
    public function edit(TodoListChild $todoListChild)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\TodoListChild $todoListChild
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $child = TodoListChild::find($request->child_id);
        if ($child) {
            $status = $child->status == 'assigned' ? 'finished' : 'assigned';
            $child->update(['status' => $status]);
        }
        return api_response(200, $child);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\TodoListChild $todoListChild
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $child = TodoListChild::find($request->child_id);
        if ($child)
            $child->delete();
    }
}
