<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ChatRoomController extends Controller
{
    /**
     * Render the chat room.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $room
     * @return \Illuminate\Http\Response
     */
    public function index($roomCode = null)
    {
        $chatRoom = ChatRoom::where('room_code', $roomCode)->firstOrFail();

        if (!$chatRoom) {
            return Redirect::route('dashboard');
        }

        $chatRoom->users()->syncWithoutDetaching(auth()->id());

        $messages = Message::where('chat_room_id', $chatRoom->id)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return Inertia::render('ChatRoom', [
            'name' => $chatRoom->name,
            'room' => $chatRoom->room_code,
            'link' => route('chatroom', ['roomCode' => $chatRoom->room_code]),
            'messages' => $messages,
        ]);
    }

    public function createRoom(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:chat_rooms,name',
        ]);

        $chatRoom = ChatRoom::create([
            'name' => $request->name,
        ]);

        return Redirect::route('chatroom', ['roomCode' => $chatRoom->room_code]);
    }
}
