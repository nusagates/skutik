<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Paginator::useBootstrap();
        $rooms = Room::latest()->paginate(1);
        return View('room.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('room.create');
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
            'title' => ['required', 'max:20', 'min:10']
        ]);
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'slug' => set_room_slug($request->title),

        ];
        $room = Room::create($data);
        $room->members()->attach(Auth::id(), ['owner' => true]);
        return redirect(route('room.show', $room->slug))->with('success', 'Room has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Room $room
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Room $room)
    {
        $chat = $room->chats;
        if ($request->ajax()) {
            return $chat;
        }
        return view('room.chat', compact(['chat', 'room']));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Room $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Room $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Room $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        //
    }
}
