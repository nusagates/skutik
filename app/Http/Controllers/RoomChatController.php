<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use App\Room;
use App\RoomChat;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomChatController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $room)
    {
        $rooms = Room::find($room);
        $rooms->chats()->create(['user_id' => Auth::id(), 'message' => $request->message]);
        broadcast(new ChatSent('', 'saas'));
        return $rooms->chats;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\RoomChat $roomChat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoomChat $roomChat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\RoomChat $roomChat
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomChat $roomChat)
    {
        //
    }
}
